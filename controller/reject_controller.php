<?php
include '../config/koneksi.php';
session_start();

function rejectBooking($idBooking)
{
    global $koneksi;

    $query = "UPDATE penyewaan SET status = 'cancel' WHERE id = '$idBooking'";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        return true;
    } else {
        return "Kesalahan query: " . mysqli_error($koneksi);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $idBookingToReject = $_GET['id_sewa'];

    $rejectResult = rejectBooking($idBookingToReject);
    if ($rejectResult === true) {
        if ($_SESSION['level'] == 'admin') {
            header("Location: ../admin/penyewaan.php");
            exit();
        } else {
            header("Location: ../user");
            exit();
        }
    } else {
        $_SESSION['error_message'] = $rejectResult;
        if ($_SESSION['level'] == 'admin') {
            header("Location: ../admin");
            exit();
        } else {
            header("Location: ../user");
            exit();
        }
    }
}
?>
