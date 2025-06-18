<?php
include_once("../mysqli.php");

if(!isset($_GET['ID'])){
    header('Location: index,php');
}

$id = $_GET ['id'];

$result = mysqli_query($mysqli, "DELETE FROM rating WHERE id_rating=$id");

header("location:index.php");
?>
