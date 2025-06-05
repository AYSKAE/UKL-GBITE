<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Informasi User</title>
    <link rel="stylesheet" href="../tambah.css">
</head>
<body>

    <div class="container">
        <h1 class="title">User</h1><br>
        <form class="form" action="tambah_user.php" method="post" enctype="multipart/form-data">
            <input type="text" name="Username" placeholder="nama" required>
            <input type="password" name="Password" placeholder="Password" required>         
            <input type="text" name="email_login" placeholder="email" required>
            <input type="Number" name="no_telp" placeholder="no_telp" required>
            <select name="status" id="status">
                <option disable selected>Choose</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            <button class="button" name="submit">submit</button>
        </form>

        <?php
        if(isset($_POST['submit'])){
            include ('../koneksi.php'); 

            $Username = mysqli_real_escape_string($mysqli, $_POST['Username']);
            $Password = mysqli_real_escape_string($mysqli, $_POST['Password']);
            $email_login = mysqli_real_escape_string($mysqli, $_POST['email_login']); 
            $no_telp = mysqli_real_escape_string($mysqli, $_POST['no_telp']);


                    $query = "INSERT INTO login_gbite(Username, Password, email_login, no_telp)
                    VALUES('$Username', '$Password', '$email_login' , '$no_telp')";
                    $result = mysqli_query($mysqli, $query);
                    
                    if ($result) {
                        echo "<script>
                            alert('Successfully Added');
                            document.location.href = 'index.php';
                        </script>";
                    } else {
                        echo "Error: " . $mysqli->error;
                    }
                }
            
            
        ?>
    </div>
</body>
</html>