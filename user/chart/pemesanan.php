<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['Username'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_SESSION['cart']) || (empty($_SESSION['cart']['makanan']))) {
    header('Location: pemesanan.php');
    exit();
}

$user = $_SESSION['Username'];
$total_makanan = 0;


function format_rupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ",", ".");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Username = htmlspecialchars($_POST['Username']);
    $email = htmlspecialchars($_POST['email_login']);
    $no_telp = htmlspecialchars($_POST['no_telp']);
    $jam_ambil = htmlspecialchars($_POST['jam_ambil']);
    $Catatan = htmlspecialchars($_POST['catatan']);

    $total_amount = 0;
    if (!empty($_SESSION['cart']['makanan'])) {
        foreach ($_SESSION['cart']['makanan'] as $item) {
            $total_amount += $item['Harga_makanan'] * $item['quantity'];
        }
    }

    $user_id = $_SESSION['Username']['id_login'] ?? null;
    $stmt = $mysqli->prepare("INSERT INTO pemesanan (id_login, Username, email_login, no_telp, jam_ambil, catatan, total_kuantitas_makanan, subtotal_makanan) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssd", $user_id, $Username, $email, $no_telp, $jam_ambil, $catatan, $total_kuantitas_makanan, $subtotal_makanan);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    $stmt_item = $mysqli->prepare("INSERT INTO makanan (id_makanan, Nama_makanan, Harga_makanan, deskripsi, Maps) VALUES (?, ?, ?, ?, ?)");
    if (!empty($_SESSION['cart']['makanan'])) {
        foreach ($_SESSION['cart']['makanan'] as $item) {
            $makanan = 'makanan';
            $id_makanan = $item['id_makanan'];
            $nama_makanan = $item['nama_makanan'];
            $quantity = $item['quantity'];
            $harga_makanan = $item['harga_makanan'];
            $subtotal = $harga_makanan * $quantity;
            $stmt_item->bind_param("isisiid", $order_id, $makanan, $id_makanan, $nama_makanan, $quantity, $harga_makanan, $subtotal);
            $stmt_item->execute();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Checkout - Gbite</title>
    <link rel="stylesheet" href="/MY_NUSANTARA/css/about.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Judson:wght@700&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@400;700&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Ek+Mukta:wght@400&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" />
</head>
<body>
    <div class="checkout-container">
        <h1>Checkout</h1>

        <?php if (isset($order_placed) && $order_placed): ?>
            <div class="order-confirmation">
                <h2>Terima kasih atas pesanan Anda!</h2>
                <p>Pesanan Anda telah berhasil diproses.</p>
                <a href="index1.php" class="back-to-home">Kembali ke Beranda</a>
            </div>
        <?php else: ?>
            <form method="POST" action="checkout.php" class="checkout-form">
                <div class="form-group">
                    <label for="name">Username</label>
                    <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($user['Username'] ?? ''); ?>" />
                </div>
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($user['email_login'] ?? ''); ?>" />
                </div>
                <div class="form-group">
                    <label for="no_telp">No.Telp</label>
                    <input type="numeric" id="no_telp" name="no_telp" required value="<?php echo htmlspecialchars($user['no_telp'] ?? ''); ?>" />
                </div>

                <div class="cart-summary">
                    <h2>Ringkasan Pesanan</h2>
                    <?php if (!empty($_SESSION['cart']['makanan'])): ?>
                        <h3>makanan</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama makanan</th>
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
                        </table>
                    <?php endif; ?>

                    <table>
                        <tr class="total-row">
                            <td colspan="3" style="text-align: right;">Total Keseluruhan:</td>
                            <td><?php echo format_rupiah($total_makanan); ?></td>
                        </tr>
                    </table>
                </div>

                <button type="submit" class="place-order-btn">Pesan Sekarang</button>
            </form>
        <?php endif; ?>
        <a href="keranjang.php" class="back-to-home">Kembali ke keranjang</a>
    </div>
</body>
</html>

<?php
$_SESSION['struk'] = [
    'nama' => $Username,
    'no_telp' => $no_telp,
    'subtotal' => $total_amount,
    'jam_ambil' => $jam_ambil,
    'alamat_makanan' => $Catatan
];


header("Location: struk.php");
exit();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ...proses penyimpanan database sudah dilakukan di atas...

    echo "<div style='max-width: 400px; margin: 30px auto; font-family: monospace; border: 1px dashed #000; padding: 20px; background-color: #fff;'>
        <h2 style='text-align: center;'>STRUK PEMESANAN</h2>
        <hr>
        <p><strong>Nama Pemesan  :</strong> " . htmlspecialchars($Username) . "</p>
        <p><strong>No. Telepon   :</strong> " . htmlspecialchars($no_telp) . "</p>
        <p><strong>Subtotal      :</strong> Rp " . number_format($total_amount, 0, ',', '.') . "</p>
        <p><strong>Jam Ambil     :</strong> " . htmlspecialchars($jam_ambil) . "</p>
        <p><strong>Alamat Makanan:</strong><br>" . nl2br(htmlspecialchars($Catatan)) . "</p>
        <hr>
        <p style='text-align: center;'>Terima kasih telah memesan di G-BITE!</p>
    </div>";
}?>