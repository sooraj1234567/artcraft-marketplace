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
    <title>Checkout</title>

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

        .container{
            width:90%;
            max-width:1100px;
            margin:auto;

            display:flex;
            gap:30px;
        }

        .left{
            flex:2;
            background:white;
            padding:25px;
            border-radius:10px;
        }

        .right{
            flex:1;
            background:white;
            padding:25px;
            border-radius:10px;
            height:fit-content;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th, td{
            padding:15px;
            border-bottom:1px solid #ddd;
            text-align:center;
        }

        img{
            width:70px;
            height:70px;
            object-fit:cover;
        }

        textarea{
            width:100%;
            padding:15px;
            margin-top:15px;
            resize:none;
        }

        button{
            width:100%;
            padding:15px;
            margin-top:20px;

            background:#1e1e2f;
            color:white;

            border:none;
            border-radius:5px;

            cursor:pointer;

            font-size:18px;
        }

        h2{
            margin-bottom:20px;
        }

    </style>

</head>
<body>

<div class="container">

    <!-- LEFT -->

    <div class="left">

        <h2>Checkout Products</h2>

        <table>

            <tr>

                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
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

                <td>
                    <?php echo $row['product_name']; ?>
                </td>

                <td>
                    ₹<?php echo $row['price']; ?>
                </td>

                <td>
                    <?php echo $row['quantity']; ?>
                </td>

                <td>
                    ₹<?php echo $subtotal; ?>
                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

    <!-- RIGHT -->

    <div class="right">

        <h2>Order Summary</h2>

        <h3>
            Total Amount: ₹<?php echo $total; ?>
        </h3>

        <form action="place_order.php" method="POST">

            <textarea
                name="shipping_address"
                rows="6"
                placeholder="Enter Shipping Address"
                required></textarea>

            <input type="hidden"
                   name="total_amount"
                   value="<?php echo $total; ?>">

            <button type="submit" name="place_order">

                Place Order

            </button>

        </form>

    </div>

</div>

</body>
</html>