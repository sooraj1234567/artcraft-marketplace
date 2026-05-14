<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

$query = "SELECT * FROM users WHERE id='$id'";
$result = mysqli_query($conn, $query);
$artist = mysqli_fetch_assoc($result);

if(isset($_POST['update_artist'])){

    $status = $_POST['seller_status'];

    $update = "UPDATE users
               SET seller_status='$status'
               WHERE id='$id'";

    if(mysqli_query($conn, $update)){

        header("Location: artists.php");

    } else {

        echo "Update Failed";

    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Artist</title>

    <style>

        body{
            font-family:Arial;
            background:#f4f4f4;
        }

        .container{
            width:500px;
            background:white;
            padding:30px;
            margin:50px auto;
            border-radius:10px;
        }

        select{
            width:100%;
            padding:12px;
            margin-top:15px;
        }

        button{
            width:100%;
            padding:12px;
            margin-top:15px;
            background:#1e1e2f;
            color:white;
            border:none;
            cursor:pointer;
        }

    </style>

</head>
<body>

<div class="container">

    <h2>Manage Artist Status</h2>

    <form method="POST">

        <select name="seller_status" required>

            <option value="pending">Pending</option>

            <option value="approved">Approved</option>

            <option value="rejected">Rejected</option>

        </select>

        <button type="submit" name="update_artist">
            Update Status
        </button>

    </form>

</div>

</body>
</html>