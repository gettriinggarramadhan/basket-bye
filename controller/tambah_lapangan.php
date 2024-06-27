<?php
include '../config/koneksi.php';

session_start();
if ($_SESSION['level'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nama']) && isset($_POST['deskripsi']) && isset($_POST['jam_buka']) && isset($_POST['jam_tutup'])) {
        $nama = $_POST['nama'];
        $deskripsi = $_POST['deskripsi'];
        $jam_buka = $_POST['jam_buka'];
        $jam_tutup = $_POST['jam_tutup'];

        // Lakukan validasi atau manipulasi data lain sesuai kebutuhan

        // Query untuk menambahkan lapangan ke database
        $query = "INSERT INTO lapangan (nama, deskripsi, jam_buka, jam_tutup) VALUES ('$nama', '$deskripsi', '$jam_buka', '$jam_tutup')";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            $_SESSION['success_message'] = "Lapangan berhasil ditambahkan";
        } else {
            $_SESSION['error_message'] = "Terjadi kesalahan saat menambahkan lapangan: " . mysqli_error($koneksi);
        }

        // Redirect kembali ke halaman yang sesuai
        header("Location: ../admin");
        exit();
    } else {
        $_SESSION['error_message'] = "Data lapangan tidak lengkap";
        header("Location: ../admin");
        exit();
    }
} else {
    // Metode HTTP yang diperlukan bukan POST
    echo "Invalid Request";
}
?>
