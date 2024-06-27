<?php
include '../config/koneksi.php';
session_start();

function approveBooking($idBooking)
{
    global $koneksi;

    $query = "UPDATE penyewaan SET status = 'booked' WHERE id = '$idBooking'";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        return true;
    } else {
        return "Kesalahan query: " . mysqli_error($koneksi);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $idBookingToApprove = $_GET['id_sewa'];

    $approveResult = approveBooking($idBookingToApprove);
    if ($approveResult === true) {
        if ($_SESSION['level'] == 'admin') {
            header("Location: ../admin/penyewaan.php");
            exit();
        } else {
            header("Location: ../user");
            exit();
        }
    } else {
        $_SESSION['error_message'] = $approveResult;
        if ($_SESSION['level'] == 'admin') {
            header("Location: ../admin");
            exit();
        } else {
            header("Location: ../user/penyewaan.php");
            exit();
        }
    }
}
?>
