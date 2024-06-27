<?php
include './config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Penyewaan Lapangan Basket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/logo/logo.png" />
    <link href="assets/css/app.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 400px; /* Adjust the height as needed */
        }

        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        body {
            background-image: url('assets/images/others/login-3.png');
        }
    </style>
</head>

<body>
   <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" style="background-color:#3F87F5; height:70px">
        <div class="container">
            <a class="navbar-brand text-white judul-logo" href="/">
                <img src="assets/images/logo/logo.png" alt="Logo" height="60" class="mr-4"> BASKETBYE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php
                    session_start();
                    if (isset($_SESSION['username'])) {
                        echo '<li class="nav-item mr-4">';
                        echo '<a class="nav-link text-white" href="user">Selamat Datang, ' . ' ' . $_SESSION['username'] . '</a>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link text-white" href="controller/logout.php">Logout</a>';
                        echo '</li>';
                    } else {
                        echo '<li class="nav-item">';
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

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1>Selamat Datang di BasketBye</h1>
                <p class="text-muted">Temukan lapangan basket berkualitas untuk kegiatan olahraga Anda.</p>
            </div>
        </div>
        
        <div class="row ">
            <div class="col-10 mx-auto">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="assets/images/lapangan/lap-1.jpg" alt="" class="slide-img"> 
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/lapangan/lap-2.jpg" alt="" class="slide-img"> 
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/lapangan/lap-3.jpg" alt="" class="slide-img"> 
                        </div>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
    <h2 class="mb-3 text-center">Daftar Lapangan</h2>
    <div class="row">
        <?php
        $sql = "SELECT * FROM lapangan";
        $result = mysqli_query($koneksi, $sql);
        $i = 0;
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)):
                $i++;
        ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow" style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title text-center border-bottom pb-2 mb-3"><?php echo $row["nama"]; ?></h3>
                            <p class="card-text"><?php echo $row["deskripsi"]; ?></p>
                            <p class="card-text">Harga Sewa: <?php echo $row["harga_sewa"]; ?></p>
                            <p class="card-text">Jam Buka: <?php echo $row["jam_buka"]; ?></p>
                            <p class="card-text">Jam Tutup: <?php echo $row["jam_tutup"]; ?></p>
                            <div class="mt-auto text-center">
                                <a href="lapangan.php?id=<?= $row['id'] ?>&ft=<?= $i ?>" class="btn btn-primary">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            endwhile;
        } else {
            echo "<p class='text-center'>Tidak ada data lapangan dalam database.</p>";
        }
        ?>
    </div>
</div>


    <footer class="text-center py-3 mt-3" style="background-color:#3F87F5;">
        <div class="container">
            <p class="mb-0 text-white">&copy; 2024 BasketBye.</p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 0,
            centeredSlides: true,
            slidesPerView: 1,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>

    <!-- Tautan Bootstrap JS (Popper.js dan Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
