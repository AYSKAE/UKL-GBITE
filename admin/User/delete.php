<?php
include_once("../koneksi.php");

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = intval($_GET['id']); // Amankan input ID

// Hapus data dari tabel-tabel terkait terlebih dahulu
mysqli_query($mysqli, "DELETE FROM pemesanan WHERE id_login = $id");
mysqli_query($mysqli, "DELETE FROM chart WHERE id_login = $id");
mysqli_query($mysqli, "DELETE FROM rating WHERE id_login = $id");

// Terakhir, hapus dari tabel login_gbite (user)
$deleteUser = mysqli_query($mysqli, "DELETE FROM login_gbite WHERE id_login = $id");

if ($deleteUser) {
    header("Location: index.php");
    exit();
} else {
    echo "Terjadi kesalahan saat menghapus pengguna.";
}
?>
