<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

$query = "DELETE FROM categories WHERE id='$id'";

if(mysqli_query($conn, $query)){

    header("Location: categories.php");

} else {

    echo "Delete Failed";

}
?>