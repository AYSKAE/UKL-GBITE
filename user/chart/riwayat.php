<?php
session_start();
if (!isset($_SESSION['Username'])) {
    header("Location: UKL_GBITE/user/login/login.php");
    exit();
}

include '../koneksi.php';
$Username = $_SESSION['Username'];

// Ambil ID user dari Username
$stmt = $mysqli->prepare("SELECT id_login FROM login_gbite WHERE Username = ?");
$stmt->bind_param("s", $Username);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
$IDuser = $userData['id_login'];
$stmt->close();

// Ambil data pesanan user dari detail_pemesanan
$query_makanan = "
    SELECT 
        p.id_pemesanan,
        p.jam_ambil,
        p.catatan,
        dp.quantity,
        dp.harga_satuan,
        m.Nama_makanan
    FROM pemesanan p
    JOIN detail_pemesanan dp ON p.id_pemesanan = dp.id_pemesanan
    JOIN makanan m ON dp.id_makanan = m.id_makanan
    WHERE p.id_login = ?
    ORDER BY p.jam_ambil DESC
";

$stmt = $mysqli->prepare($query_makanan);
$stmt->bind_param("i", $IDuser);
$stmt->execute();
$result_makanan = $stmt->get_result();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan</title>
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="riwayat.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicon@latest/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <a href="#" class="logo">G-BITE</a>
    <div class="bx bx-menu" id="menu-icon"></div>
    <ul class="navbar">
        <li><a href="/UKL_GBITE/user/profile/index.php">back</a></li>
    </ul>
</header>

<div class="transaction-history">
    <h2>Riwayat Pesanan Kuliner</h2>
    <?php
    function displayKulinerTransactions($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $total = $row['quantity'] * $row['harga_satuan'];
                echo "<div class='pemesanan'>
                    <h3>{$row['Nama_makanan']}</h3>
                    <p>Jumlah: <span>{$row['quantity']}</span></p>
                    <p>Total Harga: <span>Rp {$total}</span></p>
                    <p>Jam Ambil: <span>{$row['jam_ambil']}</span></p>
                    <p>Catatan: <span>{$row['catatan']}</span></p>
                    <a href='struk.php?id_pemesanan={$row['id_pemesanan']}' target='_blank'>
                        <button class='struk-btn'>Lihat Struk</button>
                    </a>
                </div>";
            }
        } else {
            echo "<p>Tidak ada pesanan kuliner yang ditemukan.</p>";
        }
    }

    displayKulinerTransactions($result_makanan);
    ?>
</div>

<div class="footer">
    <a href="mailto:gbite@gmail.com">Get in touch in gbite@gmail.com</a>
</div>

</body>
</html>
