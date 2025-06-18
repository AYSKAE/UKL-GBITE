<?php

include_once("../koneksi.php");

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = intval($_GET['id']); 

mysqli_query($mysqli, "DELETE FROM detail_pemesanan WHERE id_pemesanan = $id");
mysqli_query($mysqli, "DELETE FROM rating WHERE id_pemesanan = $id");

$deletepesan = mysqli_query($mysqli, "DELETE FROM pemesanan WHERE id_pemesanan = $id");

if ($deletepesan) {
    header("Location: index.php");
    exit();
} else {
    echo "Terjadi kesalahan saat menghapus pemesanan.";
}
?>