<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

$query = "SELECT * FROM orders WHERE id='$id'";
$result = mysqli_query($conn, $query);
$order = mysqli_fetch_assoc($result);

if(isset($_POST['update_order'])){
$status = $_POST['order_status'];

/* PAYMENT STATUS */

if($status == "shipped" || $status == "delivered"){

    $payment_status = "paid";

} else {

    $payment_status = "unpaid";
}

/* UPDATE ORDER */

$update = "UPDATE orders

           SET
           order_status='$status',
           payment_status='$payment_status'

           WHERE id='$id'";
    if(mysqli_query($conn, $update)){

        header("Location: orders.php");

    } else {

        echo "Update Failed";

    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Order</title>

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

    <h2>Update Order Status</h2>

    <form method="POST">

        <select name="order_status" required>

            <option value="pending">Pending</option>

            <option value="processing">Processing</option>

            <option value="shipped">Shipped</option>

            <option value="delivered">Delivered</option>

            <option value="cancelled">Cancelled</option>

        </select>

        <button type="submit" name="update_order">
            Update Order
        </button>

    </form>

</div>

</body>
</html>