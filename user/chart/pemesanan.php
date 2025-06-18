<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$user_id = $user['id_login'];

if (!isset($_SESSION['cart']) || empty($_SESSION['cart']['makanan'])) {
    header('Location: pemesanan.php');
    exit();
}

$total_makanan = 0;

function format_rupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ",", ".");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jam_ambil = htmlspecialchars($_POST['jam_ambil']);
    $catatan = htmlspecialchars($_POST['catatan']);

    $total_kuantitas_makanan = 0;
    $sub_total_makanan = 0;

    foreach ($_SESSION['cart']['makanan'] as $item) {
        $total_kuantitas_makanan += $item['quantity'];
        $sub_total_makanan += $item['Harga_makanan'] * $item['quantity'];
    }

    $id_chart = null;

    $stmt = $mysqli->prepare("INSERT INTO pemesanan (id_login, id_chart, jam_ambil, catatan, total_kuantitas_makanan, sub_total_makanan) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissid", $user_id, $id_chart, $jam_ambil, $catatan, $total_kuantitas_makanan, $sub_total_makanan);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;
        $stmt->close();

        // Insert into detail_pemesanan
       $stmt_item = $mysqli->prepare("INSERT INTO detail_pemesanan (id_pemesanan, id_makanan, quantity, harga_satuan) VALUES (?, ?, ?, ?)");

        foreach ($_SESSION['cart']['makanan'] as $item) {
        $id_makanan   = (int) $item['id_makanan'];
        $quantity     = (int) $item['quantity'];
        $harga_satuan = (float) $item['Harga_makanan'];
    
    $stmt_item->bind_param("iiid", $order_id, $id_makanan, $quantity, $harga_satuan);
    $stmt_item->execute();
}

        $stmt_item->close();
        unset($_SESSION['cart']); // Clear cart after order
        header("Location:riwayat.php?id=$order_id");
        exit();
    } else {
        echo "Gagal menyimpan pemesanan: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Checkout - Gbite</title>
    <link rel="stylesheet" href="pemesanan.css" />
</head>
<body>
    <div class="checkout-container">
        <h1>Checkout</h1>
        <form method="POST" action="pemesanan.php" class="checkout-form">
            <div class="form-group">
                <label>Username</label>
                <input type="text" readonly value="<?php echo htmlspecialchars($user['Username']); ?>" />
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" readonly value="<?php echo htmlspecialchars($user['email_login']); ?>" />
            </div>
            <div class="form-group">
                <label>No. Telp</label>
                <input type="text" readonly value="<?php echo htmlspecialchars($user['no_telp']); ?>" />
            </div>
            <div class="form-group">
                <label for="jam_ambil">Penjadwalan</label>
                <input type="datetime-local" id="jam_ambil" name="jam_ambil" required />
            </div>
            <div class="form-group">
                <label for="catatan">Catatan</label>
                <input type="text" id="catatan" name="catatan" required />
            </div>

            <div class="cart-summary">
                <h2>Ringkasan Pesanan</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart']['makanan'] as $item): 
                            $subtotal = $item['Harga_makanan'] * $item['quantity'];
                            $total_makanan += $subtotal;
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['Nama_makanan']); ?></td>
                            <td><?php echo format_rupiah($item['Harga_makanan']); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo format_rupiah($subtotal); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                            <td><strong><?php echo format_rupiah($total_makanan); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <button type="submit">Pesan Sekarang</button>
        </form>
        <a href="keranjang.php" class="back-to-home">← Kembali ke Keranjang</a>
    </div>
</body>
</html>
