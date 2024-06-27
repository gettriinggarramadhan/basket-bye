<?php
include '../config/koneksi.php';
session_start();

function cancelBooking($idBooking)
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
    $idBookingToCancel = $_GET['id_sewa'];

    $cancelResult = cancelBooking($idBookingToCancel);
    if ($cancelResult === true) {
        if ($_SESSION['level'] == 'admin') {
            header("Location: ../admin/penyewaan.php");
            exit();
        } else {
            header("Location: ../user");
            exit();
        }
    } else {
        $_SESSION['error_message'] = $cancelResult;
        if ($_SESSION['level'] == 'admin') {
            header("Location: ../admin/penyewaan.php");
            exit();
        } else {
            header("Location: ../user");
            exit();
        }
    }
}
?>
