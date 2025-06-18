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

<h1 class="heading">Data pesanan</h1>
<br>
<br><br>

<table border="1" class="table">
    <tr>
        <th>Nomor</th>
        <th>Kuantitas Makanan</th>
        <th>Subtotal</th>
        <th>Jam Ambil</th>
        <th>Aksi</th>
    </tr>

    <?php
include '../koneksi.php';

$query_mysql = mysqli_query($mysqli, "
    SELECT 
        pemesanan.id_pemesanan,
        pemesanan.total_kuantitas_makanan, 
        pemesanan.sub_total_makanan, 
        pemesanan.jam_ambil
    FROM pemesanan
    LEFT JOIN login_gbite ON pemesanan.id_login = login_gbite.id_login
    LEFT JOIN chart ON pemesanan.id_chart = chart.id_chart
");

if (!$query_mysql) {
    die("Query error: " . mysqli_error($mysqli));
}

$nomor = 1;
while($data = mysqli_fetch_array($query_mysql)) {
?>
<tr>
    <td><?= $nomor++ ?></td>
    <td><?= htmlspecialchars($data['total_kuantitas_makanan']) ?></td>
    <td><?= htmlspecialchars($data['sub_total_makanan']) ?></td>
    <td><?= htmlspecialchars($data['jam_ambil']) ?></td>
    <td>
        <a href="delete.php?id=<?= $data['id_pemesanan'] ?>" class="btn-delete" onClick="return confirm('Apakah anda yakin ingin menghapus data tersebut?')">Hapus</a>
        <a href="edit.php?id=<?= $data['id_pemesanan'] ?>" class="btn-edit">Edit</a>
    </td>
</tr>
<?php } ?>
