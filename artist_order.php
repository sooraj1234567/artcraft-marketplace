<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "

SELECT
order_items.*,
orders.order_status,
orders.created_at,
users.fullname,
products.product_name,
products.product_image

FROM order_items

JOIN orders
ON order_items.order_id = orders.id

JOIN products
ON order_items.product_id = products.id

JOIN users
ON orders.user_id = users.id

WHERE products.user_id='$user_id'

ORDER BY order_items.id DESC

";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Artist Orders</title>

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

        h2{
            margin-bottom:20px;
            color:#1e1e2f;
        }

        table{
            width:100%;
            background:white;
            border-collapse:collapse;
            border-radius:10px;
            overflow:hidden;
        }

        th, td{
            padding:15px;
            border-bottom:1px solid #ddd;
            text-align:center;
        }

        th{
            background:#1e1e2f;
            color:white;
        }

        img{
            width:80px;
            height:80px;
            object-fit:cover;
            border-radius:5px;
        }

        .status{
            padding:8px 12px;
            border-radius:20px;
            color:white;
            font-weight:bold;
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

    </style>

</head>
<body>

<h2>Products Sold By You</h2>

<table>

<tr>

    <th>Product</th>
    <th>Image</th>
    <th>Customer</th>
    <th>Quantity</th>
    <th>Status</th>
    <th>Date</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

    <td><?php echo $row['product_name']; ?></td>

    <td>

        <img src="uploads/products/<?php echo $row['product_image']; ?>">

    </td>

    <td><?php echo $row['fullname']; ?></td>

    <td><?php echo $row['quantity']; ?></td>

    <td>

        <span class="status <?php echo $row['order_status']; ?>">

            <?php echo ucfirst($row['order_status']); ?>

        </span>

    </td>

    <td><?php echo $row['created_at']; ?></td>

</tr>

<?php } ?>

</table>

</body>
</html>