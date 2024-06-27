<?php
include '../config/koneksi.php';
session_start();

function registerUser($username, $password, $email) {
    global $koneksi;

    $username = mysqli_real_escape_string($koneksi, $username);
    $email = mysqli_real_escape_string($koneksi, $email);
    $passwordHash = $password;

    // Cek apakah email sudah terdaftar
    $emailCheckQuery = "SELECT * FROM user WHERE email = '$email'";
    $emailCheckResult = mysqli_query($koneksi, $emailCheckQuery);

    if (mysqli_num_rows($emailCheckResult) > 0) {
        return "Email sudah terdaftar.";
    }

    // Insert user baru
    $query = "INSERT INTO user (username, email, password, level) VALUES ('$username', '$email', '$passwordHash', 'user')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        return true;
    } else {
        return "Kesalahan query: " . mysqli_error($koneksi);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Validasi jika username, email, atau password kosong
    if (empty($username) || empty($password) || empty($email)) {
        $_SESSION['error_message'] = "Semua field harus diisi.";
        header("Location: ../register.php");
        exit();
    }

    $registerResult = registerUser($username, $password, $email);

    if ($registerResult === true) {
        header("Location: ../login.php");
        exit();
    } else {
        $_SESSION['error_message'] = $registerResult;
        header("Location: ../register.php");
        exit();
    }
}
?>
