<?php
session_start();
include '../koneksi.php';

if (!isset($_GET['id_pemesanan'])) {
    echo "ID pemesanan tidak ditemukan.";
    exit;
}

$id_pemesanan = $_GET['id_pemesanan'];

// Ambil data pemesanan dan info user
$query = "
    SELECT p.*, l.Username, l.no_telp
    FROM pemesanan p
    JOIN login_gbite l ON p.id_login = l.id_login
    WHERE p.id_pemesanan = ?
";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $id_pemesanan);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    echo "Data pemesanan tidak ditemukan.";
    exit;
}

$detail_stmt = $mysqli->prepare("
    SELECT dp.id_makanan, m.Nama_makanan AS nama_makanan, dp.harga_satuan AS harga_makanan, dp.quantity
    FROM detail_pemesanan dp
    JOIN makanan m ON dp.id_makanan = m.id_makanan
    WHERE dp.id_pemesanan = ?
");
$detail_stmt->bind_param("i", $id_pemesanan);
$detail_stmt->execute();
$details = $detail_stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Struk Pemesanan</title>
    <link rel="stylesheet" href="struk.css">
</head>
<body>
<div class="struk">
    <h2>STRUK PEMESANAN</h2>
    <hr>
    <p><strong>Nama Pemesan :</strong> <?= htmlspecialchars($data['Username']) ?></p>
    <p><strong>No. Telepon :</strong> <?= htmlspecialchars($data['no_telp']) ?></p>
    <p><strong>Jam Ambil   :</strong> <?= htmlspecialchars($data['jam_ambil']) ?></p>
    <p><strong>Catatan     :</strong> <?= nl2br(htmlspecialchars($data['catatan'])) ?></p>

    <hr>
    <table>
        <tr>
            <th>Nama Makanan</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th>Aksi</th>
        </tr>
        <?php
        $total = 0;
        while ($row = $details->fetch_assoc()):
            $subtotal = $row['harga_makanan'] * $row['quantity'];
            $total += $subtotal;
        ?>
        <tr>
            <td><?= htmlspecialchars($row['nama_makanan']) ?></td>
            <td>Rp <?= number_format($row['harga_makanan'], 0, ',', '.') ?></td>
            <td><?= $row['quantity'] ?></td>
            <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
            <td>
                <a href="tambah_rating.php?id_pemesanan=<?= $id_pemesanan ?>&id_makanan=<?= urlencode($row['id_makanan']) ?>" style="text-decoration: none; color: white; background-color: #28A745; padding: 4px 8px; border-radius: 4px;">✍️ Beri Ulasan</a>
            </td>
        </tr>
        <?php endwhile; ?>
        <tr>
            <td colspan="3"><strong>Total:</strong></td>
            <td colspan="2"><strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></td>
        </tr>
    </table>
    <hr>
    <p style="text-align:center;">Terima kasih telah memesan di G-BITE!</p>
    <div style="text-align:center; margin-top: 20px;">
        <a href="/UKL_GBITE/user/chart/riwayat.php" class="buy-button">← Kembali ke Beranda</a>
    </div>
</div>
</body>
</html>
