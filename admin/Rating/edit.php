<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit rating</title>
    <link rel="stylesheet" href="../tambah.css">
</head>
<body>

<div class="container">
    <h1 class="title">Edit rating</h1><br>

    <?php
    include '../koneksi.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $query_mysql = mysqli_query($mysqli, "SELECT * FROM rating WHERE id_rating='$id'") or die(mysqli_error($mysqli));
        $data = mysqli_fetch_array($query_mysql);
    }

    // Proses update
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $ulasan = isset($_POST['ulasan']) ? mysqli_real_escape_string($mysqli, $_POST['ulasan']) : '';
        $bintang = isset($_POST['bintang']) ? mysqli_real_escape_string($mysqli, $_POST['bintang']) : '';


        $update = mysqli_query($mysqli, "UPDATE rating SET 
            ulasan='$ulasan', 
            bintang='$bintang',  
            WHERE id_rating='$id'");

        if ($update) {
            echo "<script>
                alert('Data berhasil diupdate');
                window.location.href = 'index.php';
            </script>";
        } else {
            echo "Update gagal: " . mysqli_error($mysqli);
        }
    }
    ?>

    <form class="form" action="edit.php?id=<?php echo $data['id_rating']; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $data['id_rating']; ?>">
        <input type="text" name="ulasan" placeholder="ulasan" value="<?php echo htmlspecialchars($data['ulasan']); ?>" required>
        <input type="Number" name="bintang" placeholder="bintang" value="<?php echo htmlspecialchars($data['bintang']); ?>" required>
        <button class="button" name="submit">Update</button>
    </form>
</div>

</body>
</html>
