<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G-BITE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header>

        <input type="checkbox" name="" id="toggler">
        <label for="toggler" class="fas fa-bars"></label>

        <a href="#" class="logo">G-<span>BITE</span></a>

        <nav class="navbar">
            <a href="#home">home</a>
            <a href="#about">About</a>
            <a href="#produk">Products</a>
            <a href="#main-footer">Contact</a>
        </nav>

        <div class="icons">
            <a href="/UKL_GBITE/user/chart/keranjang.php" class="fas fa-shopping-cart"></a>
            <?php if (isset($_SESSION['Username'])) { ?>
                <a href="../profile/index.php" class="fas fa-user"></a>
            <?php } else { ?>
                <a href="../login/index.php" class="fas fa-user"></a>
            <?php } ?>
        </div>
    </header>

    <div class="banner-image">
        <img src="/UKL_GBITE/user/gambarindex/foood.png" alt="">
    </div>

 <section class="home" id="home">
    
    <div class="content">
        <h3>delicious street foood</h3>
        <span> gading fajar street </span>
        <p>G-BITE adalah sebuah platform e-commerce yang fokus menjual produk UMKM (Usaha Mikro, Kecil, dan Menengah) dari daerah Gading Fajar. Website ini memberikan akses mudah bagi konsumen untuk membeli berbagai produk lokal berkualitas, mulai dari makanan khas, kerajinan tangan, hingga barang-barang kebutuhan sehari-hari. G-BITE bertujuan untuk mendukung dan mempromosikan potensi ekonomi lokal dengan memperkenalkan produk-produk unggulan dari pelaku UMKM Gading Fajar, sambil memberikan pengalaman belanja yang praktis dan aman.</p>
    </div>

 </section>   
 
 <section class="about" id="about">
    <h1 class="heading"> <span> about </span> us </h1>
    <div class="row">
        <div class="" style=" width: 40%;">
            <img src="/UKL_GBITE/user/gambarindex/ramai.png" alt="" class="w-setengah banner-about">
        </div>

        <div class="about-content" style=" width: 50%;">
            <h3>why choose us?</h3>
            <p> G-BITE hadir sebagai platform digital yang menghubungkan produk UMKM terbaik dari daerah Gading Fajar dengan konsumen yang
                 mencari kualitas dan keunikan lokal. Dengan desain yang modern dan ramah pengguna, G-BITE mengusung semangat untuk 
                 memberdayakan pelaku usaha mikro, kecil, dan menengah serta memberikan pengalaman berbelanja yang menyenangkan dan mudah diakses.
                 Sebagai gerbang bagi produk lokal, G-BITE bukan hanya sekadar tempat berbelanja, tapi juga menjadi sarana untuk memperkenalkan 
                 kekayaan dan kreativitas Gading Fajar kepada dunia.</p>
        </div>

    </div>
 </section>

 <section class="icons-container">

    <div class="icons">
        <img src="/UKL_GBITE/user/gambarindex/yummy.png" alt>
        <div class="info">
            <h3>Delicious food</h3>
        </div>
    </div>

    <div class="icons">
        <img src="/UKL_GBITE/user/gambarindex/higenis.png" alt>
        <div class="info">
            <h3>Hygenis</h3>
        </div>
    </div>

    <div class="icons">
        <img src="/UKL_GBITE/user/gambarindex/murah.png" alt>
        <div class="info">
            <h3>Affordable</h3>
        </div>
    </div>
 </section>

 <section class="produk" id="produk">
<?php
include '../koneksi.php';

$query_mysql = mysqli_query($mysqli, "SELECT * FROM makanan") or die(mysqli_error($mysqli));
?>

<h1>Produk</h1>

<div class="package-content">
    <?php 
    while ($data = mysqli_fetch_array($query_mysql)) { 
        $id_makanan = $data['id_makanan'];

        $query_rating = mysqli_query($mysqli, "
            SELECT AVG(bintang) as average_reviews 
            FROM rating 
            WHERE id_makanan = '$id_makanan'
        ") or die(mysqli_error($mysqli));

        $rating_data = mysqli_fetch_array($query_rating);
        $average_rating = $rating_data['average_reviews'] ?? 0;
    ?>
    <div class="box">
        <div class="thum">
            <img 
                src="/UKL_GBITE/admin/produk/gambar/<?php echo $data['foto']; ?>" 
                width="200" 
                title="<?php echo $data['Nama_makanan']; ?>"
            >
        </div>

        <div class="dest-content">
            <div class="location">
                
                    <h4><?php echo $data['Nama_makanan']; ?></h4>
                </>
                <div class="rating">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        echo $i <= $average_rating ? '★' : '☆';
                    }
                    ?>
                    <span><?php echo number_format($average_rating, 1); ?>/5</span>
                </div>
            </div>
            <a href="look.php?id=<?php echo $data['id_makanan']; ?>">
                <button class="btn-pesan">look!</button>
            </a>
        </div>
    </div>
    <?php } ?>
    </section>
    
    <footer class="main-footer">
    <div class="footer-container">
    <div class="footer-about">
      <h3>G-BITE</h3>
      <p>Gbite adalah website ekonomi kreatif yang menghadirkan berbagai pilihan kuliner khas Gading Fajar dalam satu platform digital. 
        Dengan Gbite, pengunjung dapat memesan makanan secara praktis tanpa harus antre, sehingga pengalaman kuliner menjadi lebih nyaman dan efisien.p>
    </div>
    <div class="footer-links">
      <h4>Menu</h4>
      <ul>
        <a href="#home">home</a>
            <a href="#about">About</a>
            <a href="#produk">Products</a>
            <a href="#main-footer">Contact</a>
      </ul>
    </div>
    <div class="footer-contact">
      <h4>Information</h4>
      <p>Contact Us: <a href="https://wa.me/6285143898545">Ayska Eveline</a></p>
      <br>
      <p>Email: <a href="https://mail.google.com/mail/u/0/?tf=cm&fs=1&to=aiskaku@gmail.com">biggesthug@gmail.com</a></p>
      <br>
      <p>Instagram: <a href="https://www.instagram.com/4ysell__111?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">@biggesthug</a></p>
      <br>
    </div>
  </s>
  <div class="footer-bottom">
    <p>&copy; G-BITE. All rights reserved.</p>
  </div>
</footer>
</body>
</html>