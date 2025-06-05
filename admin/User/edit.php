<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="../tambah.css">
</head>
<body>

<div class="container">
    <h1 class="title">Edit User</h1><br>

    <?php
    include '../koneksi.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $query_mysql = mysqli_query($mysqli, "SELECT * FROM login_gbite WHERE id_login='$id'") or die(mysqli_error($mysqli));
        $data = mysqli_fetch_array($query_mysql);
    }

    // Proses update
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $Username = isset($_POST['Username']) ? mysqli_real_escape_string($mysqli, $_POST['Username']) : '';
        $Password = isset($_POST['Password']) ? mysqli_real_escape_string($mysqli, $_POST['Password']) : '';
        $email_login = isset($_POST['email_login']) ? mysqli_real_escape_string($mysqli, $_POST['email_login']) : '';
        $no_telp = isset($_POST['no_telp']) ? mysqli_real_escape_string($mysqli, $_POST['no_telp']) : '';

        $update = mysqli_query($mysqli, "UPDATE login_gbite SET 
            Username='$Username', 
            Password='$Password', 
            email_login='$email_login', 
            no_telp='$no_telp' 
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

    <form class="form" action="edit.php?id=<?php echo $data['id_login']; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $data['id_login']; ?>">
        <input type="text" name="Username" placeholder="nama" value="<?php echo htmlspecialchars($data['Username']); ?>" required>
        <input type="password" name="Password" placeholder="Password" value="<?php echo htmlspecialchars($data['Password']); ?>" required>
        <input type="text" name="email_login" placeholder="email_login" value="<?php echo htmlspecialchars($data['email_login']); ?>" required>
        <input type="number" name="no_telp" placeholder="no_telp" value="<?php echo htmlspecialchars($data['no_telp']); ?>" required>
        <button class="button" name="submit">Update</button>
    </form>
</div>

</body>
</html>
