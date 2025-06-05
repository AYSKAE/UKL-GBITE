<?php
include("UKL_GBITE/login/koneksi.php");

if( !isset($_GET['id'])){
    header('Location: profile.php');
}
$id = $_GET['id'];

$result = mysqli_query($mysqli, "SELECT * FROM login_gbite WHERE id_login=$id");

while($user_data = mysqli_fetch_array($result))
{
    $username = $user_data['Username'];
    $password = $user_data['Password'];
    $email = $user_data['email_login'];
    $no_telp = $user_data['no_telp'];
    $status = $user_data['status'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/edit.css">
    <title>Data Edit</title>
</head>
<body>
    <div class="container">
    <h1 class="title">Formulir Edit User</h1>

    <form method="POST" action="proses_update.php">
        <Table>
            <tr>
                <td>Username</td>
                <td><input type="text" name="nama" value="<?php echo $username;?>"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password" value="<?php echo $password ?>"></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="teks" name="email" value="<?php echo $email ?>"></td>
            </tr>
            <tr>
                <td>No.Telp</td>
                <td><input type="numeric" name="No_telp" value="<?php echo $no_telp ?>"></td>
            </tr>
            <tr>
                <td>status</td>
                <td>
                    <select name="level" id="level" required>
                        <option disabled selected> <?php echo $status ?></option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><input type="hidden" name="id" value=<?php echo $_GET['id_login'];?>></td>
                <td><input type="submit" name="simpan" value="Simpan"></td>
            </tr>
        </Table>
    </form>
</div>
</body>

</html>