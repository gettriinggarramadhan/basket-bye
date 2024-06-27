<?php
include 'koneksi.php';

$tanggal = $_GET['tanggal'];

$query = "SELECT jam_mulai, jam_selesai, status FROM penyewaan WHERE tanggal_sewa = '$tanggal'";
$result = mysqli_query($koneksi, $query);

$bookedHours = [];

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['status'] === 'booked') {
        $bookedHours[] = [$row['jam_mulai'], $row['jam_selesai']];
    }
}

$jamBuka = strtotime('08:00:00');
$jamTutup = strtotime('22:00:00');

$availableHours = [];

$currentTime = $jamBuka;
while ($currentTime < $jamTutup) {
    $jam = date("H:i:s", $currentTime);
    $isBooked = false;

    foreach ($bookedHours as $bookedHour) {
        $bookedStartTime = strtotime($bookedHour[0]);
        $bookedEndTime = strtotime($bookedHour[1]);

        if ($currentTime >= $bookedStartTime && $currentTime < $bookedEndTime) {
            $isBooked = true;
            break;
        }
    }

    if (!$isBooked) {
        $availableHours[] = date("H:i", $currentTime); // Ubah format jam sesuai kebutuhan
    }

    $currentTime += 3600; // Tambah satu jam
}

// Keluarkan hasil dalam format JSON
header('Content-Type: application/json');
echo json_encode($availableHours);
?>
