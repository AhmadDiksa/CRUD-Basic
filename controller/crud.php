<?php
include '..\connMysqli.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['level_akses'] != 'admin') {
    header('Location: ..\interface\login.php');
    exit;
}

// CREATE (Tambah Data)
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $level_akses = $_POST['level_akses'];

    // Upload foto
    $foto = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $foto_path = "../uploads/" . basename($foto);

    if (!empty($foto) && move_uploaded_file($foto_tmp, $foto_path)) {
        // Foto berhasil diupload
    } else {
        $foto = "default.jpg"; // Jika tidak upload foto, gunakan default
    }

    // Query insert
    $stmt = $conn->prepare("INSERT INTO tb_user (nama_lengthap, user, pass, email, level_akses, foto) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Query Error: " . mysqli_error($conn));
    }
    $stmt->bind_param("ssssss", $nama, $username, $password, $email, $level_akses, $foto);
    $stmt->execute();
    
    header("Location: ..\interface\admin.php");
    exit;
}

// UPDATE (Edit Data)
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $level_akses = $_POST['level_akses'];

    // Ambil data lama
    $stmt = $conn->prepare("SELECT foto, pass FROM tb_user WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Gunakan password lama jika tidak diubah
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['pass'];

    // Update foto jika ada file baru
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_path = "../uploads/" . basename($foto);

        if (!move_uploaded_file($foto_tmp, $foto_path)) {
            echo "Gagal upload foto.";
            exit;
        }
    }

    // Query update
    $stmt = $conn->prepare("UPDATE tb_user SET nama_lengthap = ?, user = ?, pass = ?, email = ?, level_akses = ?, foto = ? WHERE id = ?");
    if (!$stmt) {
        die("Query Error: " . mysqli_error($conn));
    }
    $stmt->bind_param("ssssssi", $nama, $username, $password, $email, $level_akses, $foto, $id);
    $stmt->execute();
    
    header("Location: ..\interface\admin.php");
    exit;
}

// DELETE (Hapus Data)
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // Ambil data user sebelum hapus
    $stmt = $conn->prepare("SELECT foto FROM tb_user WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Hapus foto jika bukan default
    if ($user['foto'] && $user['foto'] != 'default.jpg' && file_exists("uploads/" . $user['foto'])) {
        unlink("../uploads/" . $user['foto']);
    }

    // Hapus user
    $stmt = $conn->prepare("DELETE FROM tb_user WHERE id = ?");
    if (!$stmt) {
        die("Query Error: " . mysqli_error($conn));
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: ..\interface\admin.php");
    exit;
}

// READ (Tampilkan Data)
$result = $conn->query("SELECT * FROM tb_user");
?>