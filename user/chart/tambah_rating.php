<?php
include '../koneksi.php';

// Ambil parameter dari URL
$id_pemesanan = $_GET['id_pemesanan'] ?? null;
$id_makanan = $_GET['id_makanan'] ?? null;

if (!$id_pemesanan || !$id_makanan) {
    echo "<script>alert('ID pemesanan atau ID makanan tidak tersedia.'); window.location.href = '../pemesanan/index.php';</script>";
    exit;
}

// Cek apakah pemesanan dan makanan sesuai
$cek = mysqli_query($mysqli, "SELECT * FROM detail_pemesanan WHERE id_pemesanan = '$id_pemesanan' AND id_makanan = '$id_makanan'");
if (mysqli_num_rows($cek) === 0) {
    echo "<script>alert('Data pemesanan tidak ditemukan.'); window.location.href = '../pemesanan/index.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ulasan = $_POST['ulasan'] ?? '';
    $bintang = $_POST['bintang'] ?? '';

    if (empty($ulasan) || empty($bintang)) {
        echo "<script>alert('Semua field wajib diisi.');</script>";
    } else {
        $simpan = mysqli_query($mysqli, "INSERT INTO rating (ulasan, bintang, id_login, id_makanan, id_pemesanan)
        SELECT '$ulasan', '$bintang', pemesanan.id_login, detail_pemesanan.id_makanan, pemesanan.id_pemesanan
        FROM pemesanan
        JOIN detail_pemesanan ON pemesanan.id_pemesanan = detail_pemesanan.id_pemesanan
        WHERE pemesanan.id_pemesanan = '$id_pemesanan' AND detail_pemesanan.id_makanan = '$id_makanan'");

       if ($simpan) {
        header("Location: /UKL_GBITE/user/landing/index.php");
        exit;
        } else {
            echo "<script>alert('Gagal menambahkan rating: " . mysqli_error($mysqli) . "');</script>";
        }
    }
} else {
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Rating - Gbite</title>
    <link rel="stylesheet" href="rating.css" />
</head>
    <h2>Beri Rating untuk Pesanan</h2>
    <form method="POST">
        <label for="ulasan">Ulasan:</label><br>
        <textarea name="ulasan" required></textarea><br><br>

        <label for="bintang">Bintang (1–5):</label><br>
        <style>
            .star-rating {
                direction: rtl;
                font-size: 1.5em;
                unicode-bidi: bidi-override;
                display: inline-block;
            }
            .star-rating input[type="radio"] {
                display: none;
            }
            .star-rating label {
                color: #ccc;
                cursor: pointer;
                padding: 0 5px;
                transition: color 0.2s ease-in-out;
            }
            .star-rating input[type="radio"]:checked ~ label {
                color: #f5b301;
            }
            .star-rating label:hover,
            .star-rating label:hover ~ label {
                color: #f5b301;
            }
        </style>
        <div class="star-rating">
            <input type="radio" id="star5" name="bintang" value="5" required><label for="star5">&#9733;</label>
            <input type="radio" id="star4" name="bintang" value="4"><label for="star4">&#9733;</label>
            <input type="radio" id="star3" name="bintang" value="3"><label for="star3">&#9733;</label>
            <input type="radio" id="star2" name="bintang" value="2"><label for="star2">&#9733;</label>
            <input type="radio" id="star1" name="bintang" value="1"><label for="star1">&#9733;</label>
        </div><br><br>

        <button type="submit">Kirim Rating</button>
    </form>
<?php
}
?>
