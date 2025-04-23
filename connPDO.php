<?php
// Informasi koneksi database
$host = "localhost"; // Host database
$username = "root"; // Username database
$password = ""; // Password database
$database = "crud"; // Nama database

try {
    // Membuat koneksi PDO
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);

    // Set mode error PDO ke exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Koneksi berhasil!";
} catch (PDOException $e) {
    // Tangani error jika koneksi gagal
    die("Koneksi gagal: " . $e->getMessage());
}

?>