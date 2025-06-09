<?php
session_start();
include '../koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID pemesanan tidak ditemukan.";
    exit;
}

if ($stmt->execute()) {
    $id_pemesanan = $stmt->insert_id;
    $stmt->close();

    header("Location: struk.php?id=$id_pemesanan");
    exit;
}

if (!isset($_SESSION['pemesanan']) || (empty($_SESSION['pemesanan']['cart']))) {
    header('Location: struk.php');
    exit();
}

if (isset($_POST['submit'])) {
    // Ambil data dari form
    $username = $_POST['Username'];
    $email = $_POST['email_login'];
    $no_telp = $_POST['no_telp_pengguna'];
    $jam_ambil = $_POST['jam_ambil'];
    $catatan = $_POST['catatan'];
    $alamat = $_POST['Maps'];

    // Ambil data dari session struk
    $data = $_SESSION['struk'];
    $user_id = $_SESSION['Username']['id_login'] ?? null;
    $id_chart = $data['id_chart'];
    $total_kuantitas = $data['total_kuantitas'];
    $subtotal = $data['subtotal'];

    $stmt = $mysqli->prepare("INSERT INTO pemesanan (id_login, id_chart, Username, email_login, no_telp, jam_ambil, catatan, total_kuantitas_makanan, subtotal_makanan, Maps) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissssssds", $user_id, $id_chart, $username, $email, $no_telp, $jam_ambil, $catatan, $total_kuantitas, $subtotal, $alamat);

    if ($stmt->execute()) {
        $id_pemesanan = $stmt->insert_id;
        $stmt->close();

        // ✅ Redirect langsung ke struk.php
        header("Location: struk.php?id=$id_pemesanan");
        exit;
    } else {
        echo "Gagal menyimpan pemesanan: " . $stmt->error;
    }
}

$id_pemesanan = $_GET['id'];
$result = $mysqli->query("SELECT * FROM pemesanan WHERE id_pemesanan = $id_pemesanan");
$data = $result->fetch_assoc();

if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}

// Fetch Maps from makanan table for this order
$maps_result = $mysqli->query("SELECT Maps FROM makanan WHERE id_pemesanan = $id_pemesanan LIMIT 1");
$maps_data = $maps_result->fetch_assoc();
$maps = $maps_data['Maps'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Struk Pemesanan</title>
    <style>
        body { font-family: monospace; background-color: #f9f9f9; }
        .struk {
            max-width: 400px; margin: 40px auto; padding: 20px;
            border: 1px dashed #000; background: #fff;
        }
        .struk h2 { text-align: center; }
        .struk p { margin: 5px 0; }
    </style>
</head>
<body>
<div class="struk">
    <h2>PEMESANAN BERHASIL</h2>
    <hr>
    <p><strong>Nama Pemesan  :</strong> <?= htmlspecialchars($data['Username']) ?></p>
    <p><strong>No. Telepon   :</strong> <?= htmlspecialchars($data['no_telp']) ?></p>
    <p><strong>Subtotal      :</strong> Rp <?= number_format($data['subtotal_makanan'], 0, ',', '.') ?></p>
    <p><strong>Jam Ambil     :</strong> <?= htmlspecialchars($data['jam_ambil']) ?></p>
    <p><strong>Alamat Makanan:</strong><br><?= nl2br(htmlspecialchars($maps)) ?></p>
    <p><strong>Catatan       :</strong> <?= htmlspecialchars($data['catatan']) ?></p>
    <hr>
    <p style="text-align:center;">Terima kasih telah memesan di G-BITE!</p>
</div>
</body>
</html>
