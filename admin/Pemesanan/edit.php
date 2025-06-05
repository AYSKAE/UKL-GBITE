<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit pesan</title>
    <link rel="stylesheet" href="../tambah.css">
</head>
<body>

<div class="container">
    <h1 class="title">Edit pesan</h1><br>

    <?php
    include '../koneksi.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $query_mysql = mysqli_query($mysqli, "SELECT * FROM pemesanan WHERE id_pemesanan='$id'") or die(mysqli_error($mysqli));
        $data = mysqli_fetch_array($query_mysql);
    }

    // Proses update
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $total_kuantitas = isset($_POST['total_kuantitas_makanan']) ? mysqli_real_escape_string($mysqli, $_POST['total_kuantitas_makanan']) : '';
        $subtotal = isset($_POST['sub_total_makanan']) ? mysqli_real_escape_string($mysqli, $_POST['sub_total_makanan']) : '';
        $jam_ambil = isset($_POST['jam_ambil']) ? mysqli_real_escape_string($mysqli, $_POST['jam_ambil']) : '';


        $update = mysqli_query($mysqli, "UPDATE pemesanan SET 
            total_kuantitas_makanan='$total_kuantitas', 
            sub_total_makanan='$subtotal', 
            jam_ambil='$jam_ambil', 
            WHERE id_login='$id'");

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

    <form class="form" action="edit.php?id=<?php echo $data['id_pemesanan']; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $data['id_pemesanan']; ?>">
        <input type="Number" name="total_kuantitas_makanan" placeholder="Total_kuantitas" value="<?php echo htmlspecialchars($data['total_kuantitas_makanan']); ?>" required>
        <input type="Number" name="sub_total_makanan" placeholder="Subtotal" value="<?php echo htmlspecialchars($data['sub_total_makanan']); ?>" required>
        <input type="text" name="jam_ambil" placeholder="Jam ambil" value="<?php echo htmlspecialchars($data['jam_ambil']); ?>" required>
        <button class="button" name="submit">Update</button>
    </form>
</div>

</body>
</html>
