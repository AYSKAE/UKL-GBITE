<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['Username'])) {
    header('Location: /UKL_GBITE/user/login/login.php');
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['increase_makanan'])) {
    $id_makanan = intval($_GET['increase_makanan']);
    if (isset($_SESSION['cart']['makanan'][$id_makanan])) {
        $_SESSION['cart']['makanan'][$id_makanan]['quantity'] += 1;
    }
    header("Location: keranjang.php");
    exit();
}

if (isset($_GET['decrease_makanan'])) {
    $id_makanan = intval($_GET['decrease_makanan']);
    if (isset($_SESSION['cart']['makanan'][$id_makanan])) {
        $_SESSION['cart']['makanan'][$id_makanan]['quantity'] -= 1;
        if ($_SESSION['cart']['makanan'][$id_makanan]['quantity'] < 1) {
            unset($_SESSION['cart']['makanan'][$id_makanan]);
        }
    }
    header("Location: keranjang.php");
    exit();
}

if (isset($_GET['add_makanan'])) {
    $id_makanan= intval($_GET['add_makanan']);
    $sql = "SELECT id_makanan, Nama_makanan, foto, Harga_makanan FROM makanan WHERE id_makanan = $id_makanan LIMIT 1";
    $result = mysqli_query($mysqli, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $makanan = mysqli_fetch_assoc($result);
        if (isset($_SESSION['cart']['makanan'][$id_makanan])) {
            $_SESSION['cart']['makanan'][$id_makanan]['quantity'] += 1;
        } else {
            $_SESSION['cart']['makanan'][$id_makanan] = [
                'id_makanan' => $makanan['id_makanan'],
                'Nama_makanan' => $makanan['Nama_makanan'],
                'foto' => $makanan['foto'],
                'Harga_makanan' => $makanan['Harga_makanan'],
                'quantity' => 1
            ];
        }
    }
    header("Location: keranjang.php");
    exit();
}

if (isset($_GET['remove_makanan'])) {
    $id_makanan = intval($_GET['remove_makanan']);
    if (isset($_SESSION['cart']['makanan'][$id_makanan])) {
        unset($_SESSION['cart']['makanan'][$id_makanan]);
    }
    header("Location: keranjang.php");
    exit();
}
$Username = $_SESSION['Username'];
$user = mysqli_query($mysqli, "SELECT * FROM login_gbite WHERE Username = '$Username'");
$userData = mysqli_fetch_assoc($user);
$id_login = $userData['id_login'];

$query = mysqli_query($mysqli, "SELECT * FROM chart 
    INNER JOIN makanan ON chart.id_makanan = makanan.id_makanan 
    WHERE id_login='$id_login'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="keranjang.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Judson:wght@700&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=El Messiri:wght@400;700&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Ek Mukta:wght@400&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" />
</head>
<body>
    <div class="container">
        <h1 class="admin-title">Keranjang Belanja</h1>

        <?php if (empty($_SESSION['cart']['makanan'])): ?>
            <p>Wahh.. keranjang anda kosong nih, belanja yuk!</p><br>
            <a href="/UKL_GBUTE/User/landing/index.php" class="buy-button">Kembali</a>
        <?php else: ?>
            <h2>Barang</h2>
            <?php if (!empty($_SESSION['cart']['makanan'])): ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_barang = 0;
                        foreach ($_SESSION['cart']['makanan'] as $item) {
                            $subtotal = $item['Harga_makanan'] * $item['quantity'];
                            $total_barang += $subtotal;
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($item['Nama_makanan']) . '</td>';
                            echo '<td>Rp ' . number_format($item['Harga_makanan'], 0, ",", ".") . '</td>';
                            echo '<td>';
                            echo '<a href="keranjang.php?decrease_makanan=' . $item['id_makanan'] . '" class="admin-link" style="font-size: 24px; padding: 5px 10px; text-decoration: none;">-</a> ';
                            echo '<span style="font-size: 18px; padding: 0 10px;">' . $item['quantity'] . '</span>';
                            echo ' <a href="keranjang.php?increase_makanan=' . $item['id_makanan'] . '" class="admin-link" style="font-size: 24px; padding: 5px 10px; text-decoration: none;">+</a>';
                            echo '</td>';
                            echo '<td>Rp ' . number_format($subtotal, 0, ",", ".") . '</td>';
                            echo '<td><a href="keranjang.php?remove_makanan=' . $item['id_makanan'] . '" onclick="return confirm(\'Hapus item ini dari keranjang?\')" class="admin-link delete-link">Hapus</a></td>';
                            echo '</tr>';
                        }
                        ?>
                        <tr>
                            <td colspan="4" style="text-align: right;"><strong>Total Makanan:</strong></td>
                            <td colspan="2"><strong>Rp <?php echo number_format($total_barang, 0, ",", "."); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Tidak ada barang di keranjang</p>
            <?php endif; ?>

            <h3>Total Keseluruhan: Rp <?php echo number_format(($total_barang ?? 0), 0, ",", "."); ?></h3><br>

           <a href="pemesanan.php" class="buy-button">Checkout</a><br>
            <br><br>
            <a href="/UKL_GBITE/user/landing/index.php" class="buy-button">Kembali</a>
            <br><br>      
        <?php endif; ?>
    </div>
</body>
</html>