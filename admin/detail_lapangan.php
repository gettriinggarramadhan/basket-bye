<?php
include '../config/koneksi.php';

session_start();
if ($_SESSION['level'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$idLapangan = $_GET['id'];

$query = "SELECT * FROM lapangan WHERE id = $idLapangan";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Kesalahan query: " . mysqli_error($koneksi));
}

if (mysqli_num_rows($result) == 0) {
    echo "Data lapangan tidak ditemukan.";
    exit();
}

$lapangan = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <title>Edit Lapangan</title>

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
    <div class="header mb-5 " style="background-color:#3F87F5;">
      <nav class="navbar mx-auto text-center navbar-expand-lg" style="background-color:#3F87F5; height:70px">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- <a class="navbar-brand text-white mr-5 pr-5" href="http://localhost/penyewaan_lap_basket/"> -->
            <img src="../assets/images/logo/logo.png" alt="Logo" height="40" class="mr-5 pr-5">
        <!-- </a> -->
        <h4 class="text-white mx-5 px-5">BasketBye</h4>
        <div class="d-flex ml-5 pl-5">
            <ul class="navbar-nav">
                <?php
                if (isset($_SESSION['username'])) {
                    echo '<li class="nav-item mx-2">';
                    echo '<a class="nav-link text-white" href="user">Selamat Datang, ' . $_SESSION['username'] . '</a>';
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

      </div>
      <div class="container mt-5 pt-5">
        <div class="main-content">
          <div class="page-header no-gutters">
            <div
              class="d-md-flex align-items-md-center justify-content-between"
            >
              <div class="media-body m-l-15">
                <div class="container mt-5 ">
                  <div class="main-content">
                    <div
                      class="page-header no-gutters align-items-center justify-content-center"
                    >
                    </div>
                    <div class="row">
                      <div class="col-8 mx-auto">
                      <h2 class="m-b-0">Edit Informasi Lapangan</h2>

                        <form
                          action="../controller/edit_lapangan.php"
                          method="POST"
                        >
                          <input
                            type="hidden"
                            name="id_lapangan"
                            value="<?= $lapangan['id']; ?>"
                          />
                          <div class="mb-3">
                            <label for="nama" class="form-label"
                              >Nama Lapangan</label
                            >
                            <input
                              type="text"
                              class="form-control"
                              id="nama"
                              name="nama"
                              value="<?= $lapangan['nama']; ?>"
                              required
                            />
                          </div>
                          <div class="mb-3">
                            <label for="deskripsi" class="form-label"
                              >Deskripsi</label
                            >
                            <textarea
                              class="form-control"
                              id="deskripsi"
                              name="deskripsi"
                              rows="3"
                              required
                            >
<?= $lapangan['deskripsi']; ?></textarea
                            >
                          </div>
                          <div class="mb-3">
                            <label for="jam_buka" class="form-label"
                              >Jam Buka</label
                            >
                            <input
                              type="time"
                              class="form-control"
                              id="jam_buka"
                              name="jam_buka"
                              value="<?= $lapangan['jam_buka']; ?>"
                              required
                            />
                          </div>
                          <div class="mb-3">
                            <label for="jam_tutup" class="form-label"
                              >Jam Tutup</label
                            >
                            <input
                              type="time"
                              class="form-control"
                              id="jam_tutup"
                              name="jam_tutup"
                              value="<?= $lapangan['jam_tutup']; ?>"
                              required
                            />
                          </div>
                          <button type="submit" class="btn btn-primary">
                            Simpan Perubahan
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <footer class="footer">
            <div class="footer-content">
              <p class="m-b-0">Penyewaan Lap Basket © 2024</p>
            </div>
          </footer>
        </div>
      </div>
    </div>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/js/vendors.min.js"></script>

    <script src="../assets/vendors/chartjs/Chart.min.js"></script>
    <script src="../assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="../assets/js/pages/dashboard-project.js"></script>

    <!-- Core JS -->
  </body>
</html>
