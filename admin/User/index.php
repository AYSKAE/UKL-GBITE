<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel="stylesheet" href="../tabell.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicon@latest/css/boxicons.min.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <ul class="navbar">
      <a href="/UKL_GBITE/admin/produk/index.php">Produk</a>
        <a href="/UKL_GBITE/admin/User/index.php">user</a>
        <a href="/UKL_GBITE/admin/pemesanan/index.php">Pemesanan</a>
        <a href="/UKL_GBITE/admin/Rating/index.php">Rating</a>
    </ul>
</header>
<h1 class="heading">Data User</h1>
<a href="/UKL_GBITE/user/login/register.php" class="btn">Tambah User</a>
<br>
<br>
<table border="1" class="table">
    <thead>
    <tr>
        <th>Nomor</th>
        <th>Username</th>
        <th>Password</th>
        <th>Email</th>
        <th>No. Telp</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
    <?php
    include '../koneksi.php';
    $query_mysql = mysqli_query($mysqli, "SELECT * FROM login_gbite") or die(mysqli_error($mysqli));
    $nomor = 1;
    while($data = mysqli_fetch_array($query_mysql)) {
    ?>
    <tr>
        <td><?php echo $nomor++; ?></td>
        <td><?php echo $data['Username']; ?></td>
        <td><?php echo $data['Password']; ?></td>
        <td><?php echo $data['email_login']; ?></td>
        <td><?php echo $data['no_telp']; ?></td>
        <td><?php echo $data['status']; ?></td>
        <td>
            <a href="delete.php?id=<?php echo $data['id_login']; ?>" class="btn-delete" onClick="return confirm('Apakah anda yakin ingin menghapus data tersebut?')">Hapus</a>
            <a href="edit.php?id=<?php echo $data['id_login']; ?>" class="btn-edit">Edit</a>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<br><br>
<a href="../logout.php" class="btn">Log Out</a>
</body>
</html>