<?php
include '../config/koneksi.php';

function rentField($idUser, $idLapangan, $tanggalSewa, $jamMulai, $jamSelesai)
{
    global $koneksi;

    $query = "INSERT INTO penyewaan (id_user, id_lapangan, tanggal_sewa, jam_mulai, jam_selesai, status) 
              VALUES ('$idUser', '$idLapangan', '$tanggalSewa', '$jamMulai', '$jamSelesai', 'pending')";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        return true;
    } else {
        return "Kesalahan query: " . mysqli_error($koneksi);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idUser = $_POST['id_user']; 
    $idLapangan = $_POST['lapangan']; 
    $tanggalSewa = $_POST['tanggal'];
    $jamMulai = $_POST['jam_mulai'];
    $jamSelesai = $_POST['jam_selesai'];
    $rentResult = rentField($idUser, $idLapangan, $tanggalSewa, $jamMulai, $jamSelesai);

    if ($rentResult === true) {
        header("Location: ../user");
        exit();
    } else {
        $_SESSION['error_message'] = $rentResult;
        header("Location: sewa.php");
        exit();
    }
}
?>
