<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <div class="container">
        <h1 class="title">Register</h1><br>

        <?php
        if(isset($_POST['submit'])){
            $username = $_POST['Username'];
            $email    = $_POST['email_login'];
            $password = $_POST['Password'];
            $no_telp  = $_POST['no_telp'];
            $status   = 'user'; // default status user

            include("koneksi.php"); // koneksi ke database gbite_query

            // Cek apakah username atau email sudah ada
            $cek = mysqli_query($mysqli, 
                "SELECT * FROM login_gbite 
                 WHERE Username = '$username' OR email_login = '$email'");

            if(mysqli_num_rows($cek) > 0){
                echo '<script>alert("Username atau Email sudah terdaftar!");</script>';
            } else {
                // Simpan password pakai hashing (opsional, tapi disarankan)
                // $password = password_hash($password, PASSWORD_DEFAULT); 

                $query = mysqli_query($mysqli,
                    "INSERT INTO login_gbite (Username, email_login, Password, no_telp, status) 
                     VALUES ('$username', '$email', '$password', '$no_telp', '$status')");

                if($query){
                    echo '<script>alert("Selamat, anda berhasil registrasi! Silakan login.");</script>';
                } else {
                    echo '<script>alert("Maaf, pendaftaran gagal.");</script>';
                }
            }
        }
        ?>

        <form class="form" action="register.php" method="post">
            <input type="text" name="Username" placeholder="Username" autocomplete="off" required>
            <input type="email" name="email_login" placeholder="Email" autocomplete="off" required>
            <input type="password" name="Password" placeholder="Password" autocomplete="off" required>
            <input type="text" name="no_telp" placeholder="Nomor Handphone" autocomplete="off" required>
            <br><br>
            <button class="button" onclick="return confirm('Anda yakin ingin registrasi?')" name="submit">Register</button>
            <div class="forgot">Sudah punya akun? <a href="index.php">Login</a></div>
        </form>
    </div>

</body>
</html>
