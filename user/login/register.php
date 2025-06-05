
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
            $username= $_POST['Username'];
            $email= $_POST['email_login'];
            $password= $_POST['Password'];
            $no_telp= $_POST['no_telp'];
            $status= $_POST['status'];

            include("koneksi.php");

            $query = mysqli_query($mysqli,
            "INSERT INTO login_gbite (Username,email_login,Password,no_telp,status) VALUES ('$username','$email','$password','$no_telp','$status')");
            if($query){
                echo'<script>alret("Selamat, anda berhasil. Silahkan Login.")</script>';
            }else{
                echo'<script>alret("Maaf anda gagal.")</script>';
            }
        }
        ?>
        <form class="form" action="register.php" method="post">
            <input type="text" name="Username" placeholder="Username" autocomplete="off" required>
            <input type="email" name="email_login" placeholder="Email" autocomplete="off" required>
            <input type="password" name="Password" placeholder="Password" autocomplete="off" required>
            <input type="text" name="no_telp" placeholder="Nomor Handphone" autocomplete="off" required>
            <select name="status" id="status">
                <option disable selected>Choose</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            <br>
           <br><button class="button" onClick="return confirm('Anda berhasil registrasi')" name="submit">Register</button>
           <div class="forgot"> Have an account? <a href="index.php">Login</a>
        </div>
    </div>
</body>
</html>