<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';

function getHargaSewa($lapangan_id, $koneksi)
{
    $query = "SELECT harga_sewa FROM lapangan WHERE id = $lapangan_id";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['harga_sewa'];
    } else {
        echo "Error fetching harga_sewa: " . mysqli_error($koneksi);
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lapangan_id = $_POST['lapangan'];

    if (!is_numeric($lapangan_id)) {
        echo "Invalid lapangan_id";
        exit();
    }

    $harga_sewa = getHargaSewa($lapangan_id, $koneksi);

    if ($harga_sewa === false) {
        echo "Error fetching harga_sewa";
        exit();
    }
   
    $_SESSION['lapangan_id'] = $lapangan_id;
    $_SESSION['harga_sewa'] = $harga_sewa;
    $_SESSION['tanggal'] = $_POST['tanggal'];
    $_SESSION['jam_mulai'] = $_POST['jam_mulai'];
    $_SESSION['jam_selesai'] = $_POST['jam_selesai'];
    // Redirect ke halaman konfirmasi
    header("Location: konfirmasi.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulir Penyewaan Lapangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/app.min.css" rel="stylesheet" />
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-image: url('assets/images/others/login-3.png');
        }

        .container-flex {
            flex: 1;
        }

        footer {
            background-color: #3F87F5;
            padding: 1rem 0;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <?php include_once 'partials/navbar.php'; ?>

    <!-- Formulir Penyewaan -->
    <div class="container-flex">
        <div class="container mt-5">
            <div class="row">
                <div class="col-6 mx-auto  px-3 py-3" style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px">
                    <h2>Formulir Penyewaan Lapangan</h2>
                    <form id="bookingForm" method="POST" action="">
                        <div class="mb-3">
                            <input type="hidden" value="<?= $_SESSION["user_id"] ?>" name="id_user">
                            <label for="lapangan" class="form-label">Pilih Lapangan</label>
                            <select class="form-select" id="lapangan" name="lapangan" required>
                                <option value="1">Lapangan 1</option>
                                <option value="2">Lapangan 2</option>
                                <option value="3">Lapangan 3</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Pilih Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>

                        <div class="mb-3">
                            <label for="jam_mulai" class="form-label">Jam Mulai</label>
                            <select class="form-select" id="jam_mulai" name="jam_mulai" required>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jam_selesai" class="form-label">Jam Selesai</label>
                            <select class="form-select" id="jam_selesai" name="jam_selesai" required>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Sewa Lapangan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="text-center">
        <div class="container">
            <p class="mb-0 text-white">&copy; 2024 BasketBye.</p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Set the minimum date to today
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('tanggal').setAttribute('min', today);

            function updateAvailableHours() {
                var tanggal = document.getElementById('tanggal').value;

                fetch('get_hour.php?tanggal=' + tanggal)
                    .then(response => response.json())
                    .then(data => {
                        var jamMulaiSelect = document.getElementById('jam_mulai');
                        jamMulaiSelect.innerHTML = '';

                        data.forEach(jam => {
                            var option = document.createElement('option');
                            option.value = jam;
                            option.text = jam;
                            jamMulaiSelect.appendChild(option);
                        });

                        var jamSelesaiSelect = document.getElementById('jam_selesai');
                        jamSelesaiSelect.innerHTML = '';

                        data.forEach(jam => {
                            var option = document.createElement('option');
                            option.value = jam;
                            option.text = jam;
                            jamSelesaiSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }

            document.getElementById('tanggal').addEventListener('change', updateAvailableHours);

            updateAvailableHours();
        });
    </script>
</body>

</html>
