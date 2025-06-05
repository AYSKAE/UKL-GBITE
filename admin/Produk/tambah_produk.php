<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Informasi produk</title>
    <link rel="stylesheet" href="../tambah.css">
</head>
<body>

    <div class="container">
        <h1 class="title">makanan</h1><br>
        <form class="form" action="tambah_produk.php" method="post" enctype="multipart/form-data">
            <input type="text" name="Nama_makanan" placeholder="nama" required>
            <input type="text" name="deskripsi" placeholder="deskripsi" required>
            <input type="file" id="Gambar" name="Gambar" accept=".jpg, .jpeg, .png" required>          
            <input type="text" name="Maps" placeholder="Maps" required>
            <input type="numeric" name="Harga_makanan" placeholder="Harga_makanan" required>
            <button class="button" name="submit">submit</button>
        </form>

        <?php
        if(isset($_POST['submit'])){
            include ('../koneksi.php'); 

            $Nama_makanan = mysqli_real_escape_string($mysqli, $_POST['Nama_makanan']);
            $deskripsi = mysqli_real_escape_string($mysqli, $_POST['deskripsi']);
            $maps = mysqli_real_escape_string($mysqli, $_POST['Maps']); 
            $harga = mysqli_real_escape_string($mysqli, $_POST['Harga_makanan']);

            // // Handle file upload
            $filename = $_FILES["Gambar"]["name"];
            $tempname = $_FILES["Gambar"]["tmp_name"];
            $folder = "./gambar/" . $filename;
            $query = "INSERT INTO makanan(Nama_makanan, Harga_makanan, deskripsi, Maps, foto)
                    VALUES('$Nama_makanan', '$harga', '$deskripsi' , '$maps', '$filename')";
                    $result = mysqli_query($mysqli, $query);
            if (move_uploaded_file($tempname, $folder)) {
        echo "<h3>&nbsp; Produk berhasil di tambahkan</h3>";
    } else {
        echo "<h3>&nbsp; Failed to upload image!</h3>";
    }

        }
        ?>
    </div>
</body>
</html>