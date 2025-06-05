<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil User</title>
    <link rel="stylesheet" href="profile.css">

    
    <link rel="stylesheet" href="https://unpkg.com/boxicon@latest/css/boxicons.min.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>

    <header>
    <div class="navbar">
      <div class="logo">
        <h2>G-BITE <span>Gading fajar</span></h2>
      </div>
      <div class="navigator">
        <a href="/UKL_GBITE/user/landing/index.php">Home</a>
      </div>
    </div>
    </header>
    <section class="profile">
        <h1 class="heading">Profil User</h1>
        <br>
        <?php
        session_start();
        if (!isset($_SESSION['Username'])) {
         header("Location:login.php");
            exit();
         }
    
        include '../koneksi.php';
        $username = $_SESSION['Username'];
        $query_mysql = mysqli_query($mysqli, "SELECT * FROM login_gbite WHERE Username = '$username'") or die(mysqli_error($mysqli));
        if ($data = mysqli_fetch_array($query_mysql)) {
        ?>
        <table border="1" class="table">
            <tr>
                <th>Username</th>
                <td><?php echo $data['Username']; ?></td>
            </tr>
            <tr>
                <th>Password</th>
                <td><?php echo $data['Password']; ?></td>
            </tr>
            <tr>
                <th>No.Telp</th>
                <td><?php echo $data['no_telp']; ?></td>
            </tr>
        </table>
        <br>
        <a href="edit.php?id=<?php echo $data['id_login']; ?>" class="btn-edit">Edit Profil</a>
        <?php }
        ?>
        <br>
        <a href="logout.php" class="btn">Log Out</a>
    </section>

</body>
</html>

