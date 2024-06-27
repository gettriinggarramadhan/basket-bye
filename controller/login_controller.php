<?php
include '../config/koneksi.php';
session_start();

function authenticateUser($email, $password)
{
    global $koneksi;

    $email = mysqli_real_escape_string($koneksi, $email);

    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            
            if ($password == $row['password']) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['level'] = $row['level'];
                if($_SESSION['level'] == 'admin'){
                    header("Location: ../admin");
                }else{
                    header("Location: ../index.php");
                }
                exit();
            } else {
                header("Location: ../login.php");

                return "Kata sandi salah.";
            }
        } else {
                header("Location: ../login.php");

            return "Username tidak terdaftar.";
        }
    } else {
        $_SESSION['error_message'] = "Kesalahan query: " . mysqli_error($koneksi);
        header("Location: login.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $loginResult = authenticateUser($email, $password);

    if ($loginResult !== true) {
        $_SESSION['error_message'] = $loginResult;
        header("Location: ../login.php");
        exit();
    }
}

?>
