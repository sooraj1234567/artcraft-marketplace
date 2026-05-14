<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

mysqli_query(

    $conn,

    "DELETE FROM wishlist
     WHERE id='$id'"
);

header("Location: wishlist.php");
?>