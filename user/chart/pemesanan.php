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
    $Username = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $no_telp = htmlspecialchars($_POST['no_telp']);
    $jam_ambil = htmlspecialchars($_POST['jam_ambil']);
    $catatan = htmlspecialchars($_POST['catatan']);

    $total_kuantitas_makanan = 0;
    $sub_total_makanan = 0;
    if (!empty($_SESSION['cart']['makanan'])) {
        foreach ($_SESSION['cart']['makanan'] as $item) {
            $total_kuantitas_makanan += $item['quantity'];
            $sub_total_makanan += $item['Harga_makanan'] * $item['quantity'];
        }
    }

    $user_id = $_SESSION['Username']['id_login'] ?? null;
    $id_chart = null; // Assuming id_chart is not used or can be null

    $stmt = $mysqli->prepare("INSERT INTO pemesanan (id_login, id_chart, jam_ambil, catatan, total_kuantitas_makanan, sub_total_makanan) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissid", $user_id, $id_chart, $jam_ambil, $catatan, $total_kuantitas_makanan, $sub_total_makanan);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;
        $stmt->close();

        // Insert each ordered item into makanan table with Maps field
        $stmt_item = $mysqli->prepare("INSERT INTO makanan (id_pemesanan, Nama_makanan, Harga_makanan, quantity, Maps) VALUES (?, ?, ?, ?, ?)");
        if (!empty($_SESSION['cart']['makanan'])) {
            foreach ($_SESSION['cart']['makanan'] as $item) {
                $nama_makanan = $item['Nama_makanan'];
                $harga_makanan = $item['Harga_makanan'];
                $quantity = $item['quantity'];
                $maps = $item['Maps'] ?? ''; // Assuming Maps is stored in cart item
                $stmt_item->bind_param("isdis", $order_id, $nama_makanan, $harga_makanan, $quantity, $maps);
                $stmt_item->execute();
            }
        }

        // Redirect to struk.php with order id
        header("Location: struk.php?id=$order_id");
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
                <a href="/UKL_GBITE/user/landing/index.php" class="back-to-home">Kembali ke Beranda</a>
            </div>
        <?php else: ?>
            <form method="POST" action="pemesanan.php" class="checkout-form">
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
                <div class="form-group">
                    <label for="jam_ambil">jam ambil</label>
                    <input type="time" id="jam_ambil" name="jam_ambil" required value="<?php echo htmlspecialchars($user['jam_ambil'] ?? ''); ?>" />
                </div>
                <div class="form-group">
                    <label for="catatan">catatan</label>
                    <input type="text" id="catatan" name="catatan" required value="<?php echo htmlspecialchars($user['catatan'] ?? ''); ?>" />
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
                                    $sub_total = $item['Harga_makanan'] * $item['quantity'];
                                    $total_makanan += $sub_total;
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['Nama_makanan']); ?></td>
                                    <td><?php echo format_rupiah($item['Harga_makanan']); ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo format_rupiah($sub_total); ?></td>
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

               <button type="submit" name="submit">Pesan Sekarang</button>
            </form>
        <?php endif; ?>
        <a href="keranjang.php" class="back-to-home">Kembali ke keranjang</a>
    </div>
</body>
</html>

