<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* GET ORDERS */

$query = "SELECT * FROM orders
          WHERE user_id='$user_id'
          ORDER BY id DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Track My Orders</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial;
        }

        body{
            background:#f4f4f4;
            padding:30px;
        }

        h1{
            margin-bottom:25px;
            color:#1e1e2f;
        }

        /* TABLE */

        table{

            width:100%;
            border-collapse:collapse;
            background:white;
            border-radius:10px;
            overflow:hidden;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }

        th, td{

            padding:15px;
            text-align:center;
            border-bottom:1px solid #ddd;
        }

        th{

            background:#1e1e2f;
            color:white;
            font-size:18px;
        }

        /* STATUS */

        .status{

            padding:10px 18px;
            border-radius:30px;
            color:white;
            font-weight:bold;
            display:inline-block;
            min-width:120px;
        }

        .pending{
            background:orange;
        }

        .processing{
            background:blue;
        }

        .shipped{
            background:purple;
        }

        .delivered{
            background:green;
        }

        .cancelled{
            background:red;
        }

        /* PAYMENT */

        .payment{

            padding:10px 18px;
            border-radius:30px;
            color:white;
            font-weight:bold;
            display:inline-block;
            min-width:120px;
        }

        .paid{
            background:green;
        }

        .unpaid{
            background:red;
        }

        /* TRACKING */

        .tracking-box{

            background:white;
            padding:40px;
            margin-bottom:30px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }

        .tracking-title{

            text-align:center;
            margin-bottom:40px;
            color:#1e1e2f;
        }

        .tracking{

            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
        }

        .step{

            text-align:center;
            flex:1;
        }

        .circle{

            width:45px;
            height:45px;
            border-radius:50%;
            background:#ccc;
            color:white;
            display:flex;
            justify-content:center;
            align-items:center;
            margin:auto;
            font-weight:bold;
        }

        .active{
            background:green;
        }

        .step p{

            margin-top:10px;
            font-size:18px;
        }

        /* RESPONSIVE */

        @media(max-width:768px){

            table{
                font-size:14px;
            }

            .tracking{
                gap:20px;
            }

            .step{
                min-width:120px;
            }
        }

    </style>

</head>
<body>

<h1>Track My Orders</h1>

<table>

<tr>

    <th>Order ID</th>

    <th>Total</th>

    <th>Payment</th>

    <th>Status</th>

    <th>Date</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

    <td>

        #<?php echo $row['id']; ?>

    </td>

    <td>

        ₹<?php echo $row['total_amount']; ?>

    </td>

    <td>

        <span class="payment <?php echo $row['payment_status']; ?>">

            <?php echo ucfirst($row['payment_status']); ?>

        </span>

    </td>

    <td>

        <span class="status <?php echo $row['order_status']; ?>">

            <?php echo ucfirst($row['order_status']); ?>

        </span>

    </td>

    <td>

        <?php echo $row['created_at']; ?>

    </td>

</tr>

<!-- TRACKING -->

<tr>

<td colspan="5">

<div class="tracking-box">

<h2 class="tracking-title">

    Order Tracking

</h2>

<div class="tracking">

    <!-- PENDING -->

    <div class="step">

        <div class="circle

        <?php

        if(

            $row['order_status'] == 'pending' ||

            $row['order_status'] == 'processing' ||

            $row['order_status'] == 'shipped' ||

            $row['order_status'] == 'delivered'

        ){

            echo 'active';
        }

        ?>">

            1

        </div>

        <p>Pending</p>

    </div>

    <!-- PROCESSING -->

    <div class="step">

        <div class="circle

        <?php

        if(

            $row['order_status'] == 'processing' ||

            $row['order_status'] == 'shipped' ||

            $row['order_status'] == 'delivered'

        ){

            echo 'active';
        }

        ?>">

            2

        </div>

        <p>Processing</p>

    </div>

    <!-- SHIPPED -->

    <div class="step">

        <div class="circle

        <?php

        if(

            $row['order_status'] == 'shipped' ||

            $row['order_status'] == 'delivered'

        ){

            echo 'active';
        }

        ?>">

            3

        </div>

        <p>Shipped</p>

    </div>

    <!-- DELIVERED -->

    <div class="step">

        <div class="circle

        <?php

        if($row['order_status'] == 'delivered'){

            echo 'active';
        }

        ?>">

            4

        </div>

        <p>Delivered</p>

    </div>

</div>

</div>

</td>

</tr>

<?php } ?>

</table>

</body>
</html>