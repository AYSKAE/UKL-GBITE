<?php
session_start();
include 'koneksi.php';
$username = $_POST['Username'];
$password = $_POST['Password'];

$login = mysqli_query($mysqli, "SELECT * FROM login_gbite WHERE Username='$username' AND `Password`='$password'");

if ($login) {
    $cek = mysqli_num_rows($login);

    if ($cek > 0) {
        $data = mysqli_fetch_assoc($login);

        $_SESSION['user'] = [
        'id_login'     => $data['id_login'],
        'Username'     => $data['Username'],
        'email_login'  => $data['email_login'],
        'no_telp'      => $data['no_telp']
    ];
    $_SESSION['status'] = $data['status'];

        if ($data['status'] == "admin") {
            $_SESSION['Username'] = $username;
            $_SESSION['status'] = "admin";
            header("Location:/UKL_GBITE/admin/user/index.php");
        } elseif ($data['status'] == "user") {
            $_SESSION['Username'] = $username;
            $_SESSION['status'] = "user";
            header("Location: /UKL_GBITE/user/landing/index.php");
        } 
    } else {
        header("Location: index.php?pesan=gagal");
    }
} else {
    echo "Error: " . mysqli_error($mysqli);
}

?>