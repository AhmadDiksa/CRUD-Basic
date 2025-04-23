<?php
session_start();
include '..\connMysqli.php';

// Redirect ke halaman login jika user belum login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../interface/login.php');
    exit;
}

// Ambil data user dari database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM tb_user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Proses update profil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Jika ada foto baru diupload
    if ($_FILES['foto']['name']) {
        $foto = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_path = "../uploads/" . basename($foto);

        if (move_uploaded_file($foto_tmp, $foto_path)) {
            $stmt = $conn->prepare("UPDATE tb_user SET nama_lengthap = ?, user = ?, email = ?, foto = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $nama, $username, $email, $foto, $user_id);
        } else {
            echo "Gagal upload foto.";
        }
    } else {
        // Jika tidak ada foto baru, update tanpa mengubah foto
        $stmt = $conn->prepare("UPDATE tb_user SET nama_lengthap = ?, user = ?, email = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nama, $username, $email, $user_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Profil berhasil diperbarui!');</script>";
        // Refresh data user
        header("Refresh:0");
    } else {
        echo "<script>alert('Gagal memperbarui profil.');</script>";
    }
}

?>