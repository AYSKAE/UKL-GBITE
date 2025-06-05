<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Makanan</title>
    <link rel="stylesheet" href="../tambah.css">
</head>
<body>

<div class="container">
    <h1 class="title">Edit Makanan</h1><br>

    <?php
    include '../koneksi.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    if(isset($_GET['id'])){
        $id = intval($_GET['id']);
        $query_mysql = mysqli_query($mysqli, "SELECT * FROM makanan WHERE id_makanan='$id'") or die(mysqli_error($mysqli));
        $data = mysqli_fetch_array($query_mysql);
    }

    if(isset($_POST['submit'])){
        $id = $_POST['id'];
        $Nama_makanan = mysqli_real_escape_string($mysqli, $_POST['Nama_makanan']);
        $deskripsi = mysqli_real_escape_string($mysqli, $_POST['deskripsi']);
        $Maps = mysqli_real_escape_string($mysqli, $_POST['Maps']);
        $Harga_makanan = mysqli_real_escape_string($mysqli, $_POST['harga']);
        // Handle file upload
        $update_image = false;
        if(isset($_FILES['Gambar']) && $_FILES['Gambar']['error'] == 0){
            $fileName = $_FILES["Gambar"]["name"];
            $fileSize = $_FILES["Gambar"]["size"];
            $tmpName = $_FILES["Gambar"]["tmp_name"];

            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));

            if (!in_array($imageExtension, $validImageExtension)) {
                echo "Invalid Image Extension";
                exit();
            } else if ($fileSize > 1000000) { 
                echo "Image Size Is Too Large";
                exit();
            } else {
                $newImageName = uniqid();
                $newImageName .= '.' . $imageExtension;

                if (!is_dir('gambar/')) {
                    mkdir('gambar/', 0777, true);
                }

                $imageFolder = 'Gambar/' . $newImageName;
                move_uploaded_file($tmpName, $imageFolder);

                $update_image = true;
            }
        }
        

        if ($update_image) {
            $result = mysqli_query($mysqli, "UPDATE makanan SET Nama_makanan='$Nama_makanan', deskripsi='$deskripsi', Gambar='$newImageName', Maps='$Maps', Harga_makanan='$Harga_makanan' WHERE id_makanan='$id'");
        } else {
            $result = mysqli_query($mysqli, "UPDATE makanan SET Nama_makanan='$Nama_makanan', deskripsi='$deskripsi', Maps='$Maps', Harga_makanan='$Harga_makanan' WHERE id_makanan='$id'");
        }
        if ($result) {
            echo "<script>
                alert('Successfully Updated');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "Error: " . $mysqli->error;
        }
    }
    
    ?>

    <form class="form" action="edit.php?id=<?php echo $data['id_makanan']; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $data['id_makanan']; ?>">
        <input type="text" name="Nama_makanan" placeholder="nama" value="<?php echo htmlspecialchars($data['Nama_makanan']); ?>" required>
        <input type="text" name="deskripsi" placeholder="deskripsi" value="<?php echo $data['deskripsi']; ?>" required>
        <input type="file" id="Gambar" name="Gambar" accept=".jpg, .jpeg, .png">
        <input type="text" name="Maps" placeholder="maps" value="<?php echo $data['Maps']; ?>" required>
        <input type="text" name="harga" placeholder="Harga_makanan" value="<?php echo $data['Harga_makanan']; ?>" required>
        <button class="button" name="submit">Update</button>
    </form>
</div>

</body>
</html>