<?php
include '../config/koneksi.php';

session_start();
if ($_SESSION['level'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$idUser = $_SESSION['user_id'];

$query = "SELECT * FROM penyewaan";

$result = mysqli_query($koneksi, $query);

if (isset($_SESSION['error_message'])) {
  echo '<script>alert("' . $_SESSION['error_message'] . '");</script>';
  unset($_SESSION['error_message']);
}

if (!$result) {
    die("Kesalahan query: " . mysqli_error($koneksi));
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <title>Admin page</title>

    <link rel="shortcut icon" href="../assets/images/logo/logo.png" />

    <link
      href="../assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css"
      rel="stylesheet"
    />

    <link href="../assets/css/app.min.css" rel="stylesheet" />
    <style>
        body{
    background-image: url('../assets/images/others/login-3.png');
            
}
    </style>
  </head>

  <body>
    <div class="app is-secondary">
      <div class="header mb-5" style="background-color:#3F87F5;">
      <nav class="navbar mx-auto text-center navbar-expand-lg" style="background-color:#3F87F5;  height:70px">
    <div class="container-fluid d-flex justify-content-between align-items-center">
            <img src="../assets/images/logo/logo.png" alt="Logo" height="40" class="mr-5 pr-5">
        <h4 class="text-white mx-5 px-5">BasketBye</h4>
        <div class="d-flex ml-5 pl-5">
            <ul class="navbar-nav">
                <?php
                if (isset($_SESSION['username'])) {
                    echo '<li class="nav-item mx-2">';
                    echo '<a class="nav-link text-white" "user">Selamat Datang, ' . $_SESSION['username'] . '</a>';
                    echo '</li>';
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link text-white" href="https://basketbye.my.id/controller/logout.php">Logout</a>';
                    echo '</li>';
                } else {
                    echo '<li class="nav-item mx-2">';
                    echo '<a class="nav-link text-white" href="login.php">Login</a>';
                    echo '</li>';
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link text-white" href="register.php">Register</a>';
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
      </div>lo
      <div class="container mt-5 pt-5">
        <div class="main-content">
          <div class="page-header no-gutters">
            <div
              class="d-md-flex align-items-md-center justify-content-between"
            >
            
              <div class="media-body m-l-15">
              <h2 class="m-b-0">Selamat Datang, <?= $_SESSION['username']?></h2>
              <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link "  href="index.php">Lapangan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active"  href="penyewaan.php">Penyewaan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tambah.php">Tambah</a>
                </li>
            </ul>
          
            <h4>Daftar Pemesanan Lapangan</h4>
<div class="table-responsive mt-5">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Lapangan</th>
                <th scope="col">Tanggal Sewa</th>
                <th scope="col">Nama Penyewa</th>
                <th scope="col">Email</th>
                <th scope="col">Jam Mulai</th>
                <th scope="col">Jam Selesai</th>
                <th scope="col">Total Biaya</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $nomor = 0;
            $query = "SELECT penyewaan.tanggal_sewa, penyewaan.id,user.username, user.email, penyewaan.jam_mulai, penyewaan.jam_selesai, penyewaan.total_biaya, penyewaan.status, lapangan.nama
            FROM penyewaan
            JOIN lapangan ON penyewaan.id_lapangan = lapangan.id
            JOIN user ON user.id = penyewaan.id_user
            ORDER BY penyewaan.tanggal_sewa DESC;";
            $result = mysqli_query($koneksi, $query);

            while ($booking = mysqli_fetch_assoc($result)):
                $nomor++;
            ?>
             <tr>
    <th scope="row"><?= $nomor ?></th>
    <td><?php echo $booking['nama']; ?></td>
    <td><?php echo $booking['tanggal_sewa']; ?></td>
    <td><?php echo $booking['username']; ?></td>
    <td><?php echo $booking['email']; ?></td>
    <td><?php echo $booking['jam_mulai']; ?></td>
    <td><?php echo $booking['jam_selesai']; ?></td>
    <td><?php echo $booking['total_biaya']; ?></td>
    <td>
        <?php
        if ($booking['status'] == 'booked') {
            echo '<h4 class="text-success">' . $booking['status'] . '</h4>';
        } elseif ($booking['status'] == 'pending') {
            echo '<h4 class="text-primary">' . $booking['status'] . '</h4>';
        } elseif ($booking['status'] == 'cancel') {
            echo '<h4 class="text-warning">' . $booking['status'] . '</h4>';
        } else {
            echo '<h4 class="text-secondary">' . $booking['status'] . '</h4>'; 
        }
        ?>
    </td>
    <td>
        <?php if ($booking['status'] == 'pending'): ?>
            <a href="../controller/approve_controller.php?id_sewa=<?= $booking['id']; ?>" class="btn btn-success">Approve</a>
            <a href="../controller/reject_controller.php?id_sewa=<?= $booking['id']; ?>" class="btn btn-danger ml-2">Reject</a>
        <?php elseif ($booking['status'] == 'booked' && strtotime($booking['tanggal_sewa']) >= strtotime(date('Y-m-d'))): ?>
            <a href="../controller/cancel_controller.php?id_sewa=<?= $booking['id']; ?>" class="btn btn-warning">Cancel</a>
        <?php endif; ?>
    </td>
</tr>


            <?php
            endwhile;

            mysqli_free_result($result);
            mysqli_close($koneksi);
            ?>
        </tbody>
    </table>
</div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class=" text-center py-3 mt-3" style="background-color:#3F87F5;">
        <div class="container">
            <p class="mb-0 text-white">&copy; 2024 BasketBye.</p>
        </div>
    </footer>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/js/vendors.min.js"></script>

    <script src="../assets/vendors/chartjs/Chart.min.js"></script>
    <script src="../assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="../assets/js/pages/dashboard-project.js"></script>

    <!-- Core JS -->
  </body>
</html>
