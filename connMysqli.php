<?php
// Informasi koneksi database
$host = "localhost"; // Host database
$username = "root"; // Username database
$password = "123456"; // Password database
$database = "crud"; // Nama database

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

?>