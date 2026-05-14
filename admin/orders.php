<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: index.php");
    exit();
}

/*

ADMIN CAN:

✅ See all marketplace orders
✅ Monitor customer orders
✅ Monitor seller orders
✅ Manage admin uploaded product orders

ADMIN CANNOT:
❌ Update seller product order status

ONLY:
Admin products can be updated by admin

*/

/* GET ALL ORDERS */

$query = "

SELECT orders.*,
users.fullname,
products.user_id AS seller_id,
products.product_name

FROM orders

JOIN users
ON orders.user_id = users.id

JOIN order_items
ON orders.id = order_items.order_id

JOIN products
ON order_items.product_id = products.id

ORDER BY orders.id DESC

";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Marketplace Orders Monitoring</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial;
        }

        body{
            background:#f4f4f4;
            padding:20px;
        }

        h2{
            margin-bottom:20px;
            color:#1e1e2f;
        }

        table{
            width:100%;
            background:white;
            border-collapse:collapse;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }

        th, td{
            padding:15px;
            border:1px solid #ddd;
            text-align:center;
        }

        th{
            background:#1e1e2f;
            color:white;
        }

        /* STATUS */

        .status{
            padding:8px 15px;
            color:white;
            border-radius:30px;
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

        /* BUTTON */

        .btn{
            background:#1e1e2f;
            color:white;
            padding:10px 15px;
            text-decoration:none;
            border-radius:5px;
            display:inline-block;
        }

        .btn:hover{
            background:#ff9800;
        }

        /* DISABLED */

        .disabled{

            background:#999;
            color:white;
            padding:10px 15px;
            border-radius:5px;
            display:inline-block;
        }

    </style>

</head>
<body>

<h2>Marketplace Orders Monitoring</h2>

<br>

<table>

<tr>

    <th>Order ID</th>

    <th>Customer</th>

    <th>Product</th>

    <th>Total Amount</th>

    <th>Payment</th>

    <th>Status</th>

    <th>Address</th>

    <th>Date</th>

    <th>Action</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

    <td>

        #<?php echo $row['id']; ?>

    </td>

    <td>

        <?php echo $row['fullname']; ?>

    </td>

    <td>

        <?php echo $row['product_name']; ?>

    </td>

    <td>

        ₹<?php echo $row['total_amount']; ?>

    </td>

    <td>

        <?php echo ucfirst($row['payment_status']); ?>

    </td>

    <td>

        <span class="status <?php echo $row['order_status']; ?>">

            <?php echo ucfirst($row['order_status']); ?>

        </span>

    </td>

    <td>

        <?php echo $row['shipping_address']; ?>

    </td>

    <td>

        <?php echo $row['created_at']; ?>

    </td>

    <td>

    <?php

    /*

    ADMIN CAN UPDATE ONLY:

    products uploaded by admin

    Assuming:
    admin uploaded products
    have user_id = 0

    */

    if($row['seller_id'] == 0){

    ?>

        <a class="btn"

        href="update_order.php?id=<?php echo $row['id']; ?>">

            Update

        </a>

    <?php } else { ?>

        <span class="disabled">

            Seller Controlled

        </span>

    <?php } ?>

    </td>

</tr>

<?php } ?>

</table>

</body>
</html>