<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$id = $_GET['id'];

$query = "DELETE FROM products
          WHERE id='$id'
          AND user_id='$user_id'";

if(mysqli_query($conn, $query)){

    header("Location: seller_products.php");

} else {

    echo "Delete Failed";
}
?>