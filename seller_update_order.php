<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

$order_item_id = $_GET['id'];

/* VERIFY SELLER PRODUCT */

$query = "

SELECT order_items.*,
products.user_id

FROM order_items

JOIN products
ON order_items.product_id = products.id

WHERE order_items.id='$order_item_id'

";

$result = mysqli_query($conn, $query);

$data = mysqli_fetch_assoc($result);

/* SECURITY */

if($data['user_id'] != $seller_id){

    die('Access Denied');
}

/* UPDATE STATUS */

if(isset($_POST['update_status'])){

    $status = $_POST['order_status'];

    /* PAYMENT */

    if($status == 'shipped' || $status == 'delivered'){

        $payment_status = 'paid';

    } else {

        $payment_status = 'unpaid';
    }

    /* UPDATE ORDER */

    mysqli_query(

        $conn,

        "UPDATE orders

         SET
         order_status='$status',
         payment_status='$payment_status'

         WHERE id='".$data['order_id']."'"
    );

    header("Location: seller_orders.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Order</title>

    <style>

        body{
            background:#f4f4f4;
            font-family:Arial;
        }

        .container{
            width:450px;
            background:white;
            padding:30px;
            margin:60px auto;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }

        h2{
            margin-bottom:20px;
            text-align:center;
        }

        select{
            width:100%;
            padding:14px;
            margin-top:15px;
        }

        button{
            width:100%;
            padding:14px;
            margin-top:20px;
            background:#1e1e2f;
            color:white;
            border:none;
            cursor:pointer;
            border-radius:5px;
        }

    </style>

</head>
<body>

<div class="container">

    <h2>Update Order Status</h2>

    <form method="POST">

        <select name="order_status" required>

            <option value="pending">

                Pending

            </option>

            <option value="processing">

                Processing

            </option>

            <option value="shipped">

                Shipped

            </option>

            <option value="delivered">

                Delivered

            </option>

            <option value="cancelled">

                Cancelled

            </option>

        </select>

        <button type="submit"
                name="update_status">

            Update Status

        </button>

    </form>

</div>

</body>
</html>