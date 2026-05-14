<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* TOTAL PRODUCTS */

$product_count = mysqli_num_rows(

    mysqli_query(
        $conn,
        "SELECT * FROM products
         WHERE user_id='$user_id'"
    )
);

/* TOTAL ORDERS */

$order_count = mysqli_num_rows(

    mysqli_query(

        $conn,

        "SELECT order_items.*

         FROM order_items

         JOIN products
         ON order_items.product_id = products.id

         WHERE products.user_id='$user_id'"
    )
);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Seller Dashboard</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial;
        }

        body{
            background:#f4f4f4;
            display:flex;
        }

        /* SIDEBAR */

        .sidebar{
            width:250px;
            height:100vh;
            background:#1e1e2f;
            color:white;
            padding:20px;
            position:fixed;
        }

        .sidebar h2{
            text-align:center;
            margin-bottom:30px;
        }

        .sidebar ul{
            list-style:none;
        }

        .sidebar ul li{
            margin:20px 0;
        }

        .sidebar ul li a{
            color:white;
            text-decoration:none;
            display:block;
            padding:12px;
            border-radius:5px;
            transition:0.3s;
        }

        .sidebar ul li a:hover{
            background:#34344a;
        }

        /* MAIN */

        .main{
            margin-left:250px;
            width:100%;
            padding:30px;
        }

        .header{
            background:white;
            padding:20px;
            border-radius:10px;
            margin-bottom:25px;
        }

        .cards{
            display:grid;

            grid-template-columns:
            repeat(auto-fit,minmax(250px,1fr));

            gap:20px;
        }

        .card{
            background:white;
            padding:30px;
            border-radius:10px;
            text-align:center;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }

        .card h1{
            font-size:40px;
            color:#1e1e2f;
            margin-bottom:10px;
        }

        .card p{
            color:gray;
            font-size:18px;
        }

    </style>

</head>
<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <h2>Seller Panel</h2>

    <ul>

        <li>
            <a href="seller_dashboard.php">
                Dashboard
            </a>
        </li>

        <li>
            <a href="seller_products.php">
                My Products
            </a>
        </li>

        <li>
            <a href="seller_add_product.php">
                Add Product
            </a>
        </li>

        <li>
            <a href="seller_orders.php">
                Orders
            </a>
        </li>

        <li>
            <a href="index.php">
                Back To Website
            </a>
        </li>

    </ul>

</div>

<!-- MAIN -->

<div class="main">

    <div class="header">

        <h1>

            Welcome Seller,
            <?php echo $_SESSION['user_name']; ?>

        </h1>

    </div>

    <div class="cards">

        <div class="card">

            <h1>
                <?php echo $product_count; ?>
            </h1>

            <p>Total Products</p>

        </div>

        <div class="card">

            <h1>
                <?php echo $order_count; ?>
            </h1>

            <p>Total Orders</p>

        </div>

    </div>

</div>

</body>
</html>