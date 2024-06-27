<?php
$servername = "localhost"; // Ganti sesuai dengan host database Anda
$username = ""; // Ganti sesuai dengan nama pengguna database Anda
$password = ""; // Ganti sesuai dengan kata sandi database Anda
$dbname = ""; // Ganti sesuai dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $lapanganId = $_GET['id'];
    $tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date("Y-m-d");

    $sql = "SELECT id, nama, deskripsi, harga_sewa, jam_buka, jam_tutup, image FROM lapangan WHERE id = $lapanganId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $sqlBookedHours = "SELECT jam_mulai, jam_selesai FROM penyewaan WHERE id_lapangan = $lapanganId AND tanggal_sewa = '$tanggal'";
        $resultBookedHours = $conn->query($sqlBookedHours);
        $bookedHours = [];

        if ($resultBookedHours->num_rows > 0) {
            while ($bookedRow = $resultBookedHours->fetch_assoc()) {
                $bookedHours[] = [$bookedRow['jam_mulai'], $bookedRow['jam_selesai']];
            }
        }

        $availableHours = [];
        $jamBuka = $row['jam_buka'];
        $jamTutup = $row['jam_tutup'];
        $currentTime = strtotime($jamBuka);
        $endTime = strtotime($jamTutup);

        while ($currentTime < $endTime) {
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
                $availableHours[] = date("H:i", $currentTime);
            }

            $currentTime += 3600;
        }
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Lapangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/app.min.css" rel="stylesheet" />
    <style>
        body {
            background-image: url('assets/images/others/login-3.png');
            background-size: cover;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include_once 'partials/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-7">
                <img src="assets/images/lapangan/<?php echo $row['image']; ?>" alt="<?php echo $row['nama']; ?>" class="img-fluid" />
            </div>
            <div class="col-5 p-4" style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; background: rgba(255, 255, 255, 0.8);">
                <form action="" method="get" class="mb-3">
                    <label for="tanggal" class="form-label">Pilih Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="<?php echo $tanggal; ?>" class="form-control" required>
                    <input type="hidden" name="id" value="<?php echo $lapanganId; ?>">
                    <button type="submit" class="btn btn-primary mt-2">Tampilkan Jam Tersedia</button>
                </form>

                <h1 class="mt-4"><?php echo $row["nama"]; ?></h1>
                <p><?php echo $row["deskripsi"]; ?></p>
                <p>Harga Sewa: Rp<?php echo $row["harga_sewa"]; ?> per jam</p>
                <p>Jam Operasional: <?php echo $row["jam_buka"] . " - " . $row["jam_tutup"]; ?></p>

                <div class="row">
                    <div class="col-6">
                        <div id="availableHours">
                            <ul>
                                <?php
                                if (!empty($availableHours)) {
                                    foreach ($availableHours as $jam) {
                                        echo "<li>$jam</li>";
                                    }
                                } else {
                                    echo "<li>Tidak ada jam tersedia pada tanggal tersebut.</li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-6">
                        <a href="sewa.php?id=<?php echo $lapanganId; ?>&tanggal=<?php echo $tanggal; ?>" class="btn btn-success rent-button">Sewa Lapangan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center py-3 mt-3" style="background-color:#3F87F5;">
        <div class="container">
            <p class="mb-0 text-white">&copy; 2024 BasketBye.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById("tanggal").setAttribute('min', today);

            function updateAvailableHours() {
                var tanggal = document.getElementById("tanggal").value;

                fetch("get_hour.php?tanggal=" + tanggal + "&id=" + <?php echo $lapanganId; ?>)
                    .then(response => response.json())
                    .then(data => {
                        var availableHoursDiv = document.getElementById("availableHours");
                        availableHoursDiv.innerHTML = "";

                        if (data.length > 0) {
                            var availableHoursList = document.createElement("ul");
                            data.forEach(jam => {
                                var listItem = document.createElement("li");
                                listItem.textContent = jam;
                                availableHoursList.appendChild(listItem);
                            });

                            availableHoursDiv.appendChild(availableHoursList);
                        } else {
                            availableHoursDiv.textContent = "Tidak ada jam tersedia pada tanggal tersebut.";
                        }
                    })
                    .catch(error => console.error("Error:", error));
            }

            document.getElementById("tanggal").addEventListener("change", updateAvailableHours);

            updateAvailableHours();
        });
    </script>
</body>
</html>

<?php
    } else {
        // Jika lapangan tidak ditemukan
        echo "Lapangan tidak ditemukan.";
    }
} else {
    echo "ID lapangan tidak valid.";
}

$conn->close();
?>
