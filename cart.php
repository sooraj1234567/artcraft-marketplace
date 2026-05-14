<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT cart.*, products.product_name,
          products.price,
          products.product_image

          FROM cart

          JOIN products
          ON cart.product_id = products.id

          WHERE cart.user_id='$user_id'";

$result = mysqli_query($conn, $query);

$total = 0;

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Cart</title>

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

        table{
            width:100%;
            background:white;
            border-collapse:collapse;
        }

        th, td{
            padding:15px;
            border:1px solid #ddd;
            text-align:center;
        }

        img{
            width:80px;
            height:80px;
            object-fit:cover;
        }

        .checkout-btn{
            display:inline-block;

            margin-top:20px;

            background:#1e1e2f;
            color:white;

            padding:15px 30px;

            text-decoration:none;

            border-radius:5px;
        }

        h2{
            margin-bottom:20px;
        }

    </style>

</head>
<body>

<h2>My Shopping Cart</h2>

<table>

<tr>

    <th>Image</th>
    <th>Product</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Total</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){

    $subtotal = $row['price'] * $row['quantity'];

    $total += $subtotal;

?>

<tr>

    <td>

        <img src="uploads/products/<?php echo $row['product_image']; ?>">

    </td>

    <td><?php echo $row['product_name']; ?></td>

    <td>₹<?php echo $row['price']; ?></td>

    <td><?php echo $row['quantity']; ?></td>

    <td>₹<?php echo $subtotal; ?></td>

</tr>

<?php } ?>

</table>

<h2 style="margin-top:20px;">

    Grand Total: ₹<?php echo $total; ?>

</h2>

<a class="checkout-btn" href="checkout.php">

    Proceed To Checkout

</a>

</body>
</html>