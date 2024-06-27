<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lapangan_id = $_SESSION['lapangan_id'];
    $harga_sewa = $_SESSION['harga_sewa'];
    $id_user = $_SESSION['user_id'];
    $tanggal = $_SESSION['tanggal'];
    $jam_mulai = $_SESSION['jam_mulai'];
    $jam_selesai = $_SESSION['jam_selesai'];

    $total_biaya = calculateTotalBiaya($harga_sewa, $jam_mulai, $jam_selesai);

    saveBookingToDatabase($id_user, $lapangan_id, $tanggal, $jam_mulai, $jam_selesai, $total_biaya);
}

function calculateTotalBiaya($harga_sewa, $jam_mulai, $jam_selesai)
{
    $durasi_sewa = strtotime($jam_selesai) - strtotime($jam_mulai);
    $total_biaya = ($durasi_sewa / 3600) * $harga_sewa;
    return $total_biaya;
}

function saveBookingToDatabase($id_user, $lapangan_id, $tanggal, $jam_mulai, $jam_selesai, $total_biaya)
{
    include 'koneksi.php';

    $query = "INSERT INTO penyewaan (id_user, id_lapangan, tanggal_sewa, jam_mulai, jam_selesai, total_biaya) VALUES ('$id_user', '$lapangan_id', '$tanggal', '$jam_mulai', '$jam_selesai', '$total_biaya')";
    
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: user");
        exit();
    } else {
        echo "Terjadi kesalahan saat menyimpan penyewaan.";
    }
}

$lapangan_id = $_SESSION['lapangan_id'];
$tanggal = $_SESSION['tanggal'];
$jam_mulai = $_SESSION['jam_mulai'];
$jam_selesai = $_SESSION['jam_selesai'];
$total_biaya = calculateTotalBiaya($_SESSION['harga_sewa'], $jam_mulai, $jam_selesai);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Penyewaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/app.min.css" rel="stylesheet" />
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .container-flex {
            flex: 1;
        }

        footer {
            background-color: #3F87F5;
            padding: 1rem 0;
        }

        body {
            background-image: url('assets/images/others/login-3.png');
        }

        li {
            list-style: none;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <?php include_once 'partials/navbar.php'; ?>

    <!-- Informasi Konfirmasi Penyewaan -->
    <div class="container-flex">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 offset-md-3 py-3 px-3" style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px">
                    <h2>Konfirmasi Penyewaan</h2>
                    <p>Terima kasih! Berikut adalah rincian penyewaan Anda:</p>
                    <ul>
                        <li>Lapangan ID: <?php echo $lapangan_id; ?></li>
                        <li>Tanggal: <?php echo $tanggal; ?></li>
                        <li>Jam Mulai: <?php echo $jam_mulai; ?></li>
                        <li>Jam Selesai: <?php echo $jam_selesai; ?></li>
                        <li>Total Biaya: $<?php echo number_format($total_biaya, 2); ?></li>
                    </ul>
                    <p>Silakan selesaikan pembayaran untuk menyelesaikan proses penyewaan.</p>
                    <form method="POST" action="konfirmasi.php">
                        <!-- Include any additional data you want to submit -->
                        <input type="hidden" name="lapangan_id" value="<?php echo $lapangan_id; ?>">
                        <input type="hidden" name="tanggal" value="<?php echo $tanggal; ?>">
                        <input type="hidden" name="jam_mulai" value="<?php echo $jam_mulai; ?>">
                        <input type="hidden" name="jam_selesai" value="<?php echo $jam_selesai; ?>">
                        <input type="hidden" name="total_biaya" value="<?php echo $total_biaya; ?>">
                        <button type="submit" class="btn btn-primary">Konfirmasi Penyewaan</button>
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
</body>

</html>
