<?php
include '../config/koneksi.php';

function cancelBooking($idBooking)
{
    global $koneksi;

    $query = "DELETE FROM  lapangan  WHERE id = '$idBooking'";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        return true;
    } else {
        return "Kesalahan query: " . mysqli_error($koneksi);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $idBookingToCancel = $_GET['id'];

    $cancelResult = cancelBooking($idBookingToCancel);

    if ($cancelResult === true) {
        header("Location: ../admin");
        exit();
    } else {
        $_SESSION['error_message'] = $cancelResult;
        header("Location: ../admin");
        exit();
    }
}
?>
