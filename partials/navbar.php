<nav class="navbar navbar-expand-lg" style="background-color:#3F87F5; height:70px">

    <div class="container">
        
    <a class="navbar-brand text-white" href="/">
            <img src="https://basketbye.my.id/assets/images/logo/logo.png" alt="Logo" height="60" class="mr-4"> BASKETBYE
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
       
            <ul class="navbar-nav ms-auto">
                <?php
               if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
                if (isset($_SESSION['username'])) {
                    echo '<li class="nav-item mr-3">';
                    echo '<a class="nav-link text-white" href="user">Selamat Datang, ' . $_SESSION['username'] . '</a>';
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