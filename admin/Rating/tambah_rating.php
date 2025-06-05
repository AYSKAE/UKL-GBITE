<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Informasi Produk - Rating</title>
    <link rel="stylesheet" href="../tambah.css">
</head>
<body>

    <div class="container">
        <h1 class="title">Rating</h1><br>

        <!-- Form untuk input ulasan dan bintang -->
        <form class="form" action="" method="post">
            <input type="text" name="ulasan" placeholder="Ulasan" required>
            <input type="number" name="bintang" placeholder="Bintang (1-5)" min="1" max="5" required>
            <button class="button" name="submit">Submit</button>
        </form>

        <?php
        session_start(); // Tambahkan ini di atas sebelum akses session
include('../koneksi.php'); 

if (isset($_POST['submit'])) {
    // Cek apakah user sudah login
    if (!isset($_SESSION['id_login'])) {
        echo "<script>alert('Anda harus login terlebih dahulu');</script>";
        exit;
    }

    $ulasan = mysqli_real_escape_string($mysqli, $_POST['ulasan']);
    $bintang = mysqli_real_escape_string($mysqli, $_POST['bintang']);
    $id_login = $_SESSION['id_login']; // ambil dari session

    if ($bintang < 1 || $bintang > 5) {
        echo "<script>alert('Nilai bintang harus antara 1 sampai 5');</script>";
    } else {
        // INSERT dengan id_login
        $query = "INSERT INTO rating (ulasan, bintang, id_login) VALUES ('$ulasan', '$bintang', '$id_login')";
        $result = mysqli_query($mysqli, $query);

        if ($result) {
            echo "<script>
                alert('Berhasil ditambahkan!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "Error saat menambahkan: " . $mysqli->error;
        }
    }
}

        ?>
    </div>
</body>
</html>
