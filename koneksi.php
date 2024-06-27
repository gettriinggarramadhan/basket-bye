<?php
$host = "localhost"; // Ganti sesuai dengan host database Anda
$username = ""; // Ganti sesuai dengan nama pengguna database Anda
$password = ""; // Ganti sesuai dengan kata sandi database Anda
$database = ""; // Ganti sesuai dengan nama database Anda

// Buat koneksi
$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
