

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GBITE</title>
    <link rel="stylesheet" href="look.css">

    <link rel="stylesheet" href="https://unpkg.com/boxicon@latest/css/boxicons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <a href="#" class="logo">G-BITE</a>
</header>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    include '../koneksi.php';
    $query_mysql = mysqli_query($mysqli, "SELECT * FROM makanan WHERE id_makanan='$id'") or die(mysqli_error($mysqli));
    if ($data = mysqli_fetch_array($query_mysql)) {
       $query_rating = mysqli_query($mysqli, "
            SELECT AVG(bintang) as average_bintang
            FROM rating
            WHERE id_makanan = '$id'
        ") or die(mysqli_error($mysqli));
        $rating_data = mysqli_fetch_array($query_rating);
        $average_reviews = $rating_data['average_bintang'];
?>
<div class="container">
    <h1 class="title"><?php echo $data['Nama_makanan']; ?></h1><br>
    <img src="/UKL_GBITE/admin/produk/gambar/<?php echo $data['foto']; ?>" alt="<?php echo $data['Nama_makanan']; ?>" width="300"><br><br>
    <div class="data-makanan">
    <div class="container-rating">
    <div class="feedback-rating"> 
        <h2>Ulasan</h2>
        <?php
        $query_feedback = mysqli_query($mysqli, "
            SELECT rating.bintang, rating.ulasan, login_gbite.Username 
            FROM rating
            INNER JOIN login_gbite ON rating.id_login = login_gbite.id_login
            INNER JOIN pemesanan ON rating.id_pemesanan = pemesanan.id_pemesanan
            INNER JOIN makanan ON rating.id_makanan = makanan.id_makanan 
            WHERE rating.id_makanan = '$id'
        ") or die(mysqli_error($mysqli));

        if (mysqli_num_rows($query_feedback) > 0) {
            while ($feedback = mysqli_fetch_array($query_feedback)) {
                echo "<div class='feedback-item'>";
                echo "<p><strong>Nama Pengguna: </strong>" . htmlspecialchars($feedback['Username']) . "</p>";
                echo "<p><strong>Rating: </strong></p>";
                echo "<div class='rating'>";
                for ($i = 1; $i <= 5; $i++) {
                    echo $i <= $feedback['bintang'] ? "★" : "☆";
                }
                echo "</div>";
                echo "<p><strong>Feedback: </strong>" . htmlspecialchars($feedback['ulasan']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Belum ada feedback dan rating untuk kuliner ini.</p>";
        }
        ?>
    </div>
</div> 
    <table>    
    <tr><th><strong>Harga : <?php echo $data['Harga_makanan']; ?></strong></th></tr>
    <tr><th><strong>Maps : <?php echo $data['Maps']; ?></strong></th></tr>
    <tr><th><strong>Deskripsi : <?php echo $data['deskripsi']; ?></strong></th></tr>
    </table>
    </div>
   <div class="button-container">
    <a href="/UKL_GBITE/User/landing/index.php" class="btn-pesan">Kembali</a>
    <?php
    echo '<a href="/UKL_GBITE/user/chart/keranjang.php?add_makanan=' . $data["id_makanan"] . '" class="buy-button">Add to cart</a>';
    ?> </div>
</div>

</div>

<?php
    } else {
        echo "<p>makanan tidak ditemukan.</p>";
    }
} else {
    echo "<p>ID makanan tidak ditemukan.</p>";
}
?>



<footer>
  <div class="footer">
    <p>&copy; 2025 GBITE. All rights reserved.</p>
  </div>
</footer>
</body>
</html>