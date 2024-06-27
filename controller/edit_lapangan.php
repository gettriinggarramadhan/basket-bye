<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idLapangan = $_POST['id_lapangan'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $jamBuka = $_POST['jam_buka'];
    $jamTutup = $_POST['jam_tutup'];

    if (empty($nama) || empty($deskripsi) || empty($jamBuka) || empty($jamTutup)) {
        $_SESSION['error_message'] = 'Semua kolom harus diisi';
        header("Location: ../admin/edit_lapangan.php?id_lapangan=$idLapangan");
        exit();
    }

    $query = "UPDATE lapangan SET nama='$nama', deskripsi='$deskripsi', jam_buka='$jamBuka', jam_tutup='$jamTutup' WHERE id=$idLapangan";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['success_message'] = 'Data lapangan berhasil diperbarui';
        header("Location: ../admin/index.php");
        exit();
    } else {
        $_SESSION['error_message'] = 'Terjadi kesalahan saat memperbarui data lapangan';
        header("Location: ../admin/detail_lapangan.php?id=$idLapangan");
        exit();
    }
} else {
    header("Location: ../admin/index.php");
    exit();
}
?>
