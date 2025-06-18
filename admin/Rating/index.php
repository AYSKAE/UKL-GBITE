<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin - Rating</title>
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
        <a href="/UKL_GBITE/admin/User/index.php">User</a>
        <a href="/UKL_GBITE/admin/pemesanan/index.php">Pemesanan</a>
        <a href="/UKL_GBITE/admin/Rating/index.php">Rating</a>
    </ul>
</header>

<h1 class="heading">Data Rating</h1>
<br>
<a href="tambah_rating.php" class="btn">Tambah Rating</a>
<br><br>

<table border="1" class="table">
    <tr>
        <th>Nomor</th>
        <th>Username</th>
        <th>Nama Makanan</th>
        <th>Ulasan</th>
        <th>Bintang</th>
        <th>Aksi</th>
    </tr>

    <?php
    include '../koneksi.php';

    
        $query_mysql = mysqli_query($mysqli, "
    SELECT 
        rating.id_rating,
        rating.ulasan,
        rating.bintang,
        login_gbite.username,
        makanan.nama_makanan
    FROM rating
    LEFT JOIN login_gbite ON rating.id_login = login_gbite.id_login
    LEFT JOIN makanan ON rating.id_makanan = makanan.id_makanan
    LEFT JOIN pemesanan ON rating.id_pemesanan = pemesanan.id_pemesanan
") or die(mysqli_error($mysqli));

    $nomor = 1;
    while($data = mysqli_fetch_array($query_mysql)) {
    ?>
    <tr>
        <td><?php echo $nomor++; ?></td>
        <td><?php echo $data['username']; ?></td>
        <td><?php echo $data['nama_makanan']; ?></td>
        <td><?php echo $data['ulasan']; ?></td>
        <td><?php echo $data['bintang']; ?></td>
        <td>
            <a href="delete.php?id=<?php echo $data['id_rating']; ?>" class="btn-delete" onclick="return confirm('Apakah anda yakin ingin menghapus data tersebut?')">Hapus</a>
            <a href="edit.php?id=<?php echo $data['id_rating']; ?>" class="btn-edit">Edit</a>
        </td>
    </tr>
    <?php } ?>
</table>

<br><br>
<a href="../logout.php" class="btn">Log Out</a>

</body>
</html>
