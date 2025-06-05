<?php
session_start();

// Cek apakah data struk tersedia
if (!isset($_SESSION['struk'])) {
    echo "Data struk tidak tersedia.";
    exit();
}

$data = $_SESSION['struk'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Struk Pemesanan</title>
    <style>
        body {
            font-family: monospace;
            background-color: #f9f9f9;
        }
        .struk {
            max-width: 400px;
            margin: 40px auto;
            padding: 20px;
            border: 1px dashed #000;
            background: #fff;
        }
        .struk h2 {
            text-align: center;
        }
        .struk p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="struk">
        <h2>PEMESANAN BERHASIL</h2>
        <hr>
        <p><strong>Nama Pemesan  :</strong> <?= htmlspecialchars($data['nama']) ?></p>
        <p><strong>No. Telepon   :</strong> <?= htmlspecialchars($data['no_telp']) ?></p>
        <p><strong>Subtotal      :</strong> Rp <?= number_format($data['subtotal'], 0, ',', '.') ?></p>
        <p><strong>Jam Ambil     :</strong> <?= htmlspecialchars($data['jam_ambil']) ?></p>
        <p><strong>Alamat Makanan:</strong><br> <?= nl2br(htmlspecialchars($data['alamat_makanan'])) ?></p>
        <hr>
        <p style="text-align:center;">Terima kasih telah memesan di G-BITE!</p>
    </div>
</body>
</html>
