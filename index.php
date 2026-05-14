<?php
session_start();
include("config/db.php");

$product_query = "SELECT * FROM products 
                  ORDER BY id DESC LIMIT 3";

$product_result = mysqli_query($conn, $product_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>ArtCraft Marketplace</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial;
        }

        body{
            background:#f4f4f4;
        }

        /* NAVBAR */

        .navbar{
            background:#1e1e2f;
            padding:15px 50px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .logo{
            color:white;
            font-size:28px;
            font-weight:bold;
        }

        .nav-links{
            display:flex;
            align-items:center;
            gap:20px;
        }

        .nav-links a{
            color:white;
            text-decoration:none;
            font-size:17px;
            transition:0.3s;
        }

        .nav-links a:hover{
            color:#ff9800;
        }

        /* HERO */

        .hero{
            height:500px;

            background:
            linear-gradient(rgba(0,0,0,0.5),
            rgba(0,0,0,0.5)),
            url('https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?q=80&w=1600');

            background-size:cover;
            background-position:center;

            display:flex;
            justify-content:center;
            align-items:center;
            flex-direction:column;

            color:white;
            text-align:center;
        }

        .hero h1{
            font-size:60px;
            margin-bottom:20px;
        }

        .hero p{
            font-size:22px;
            margin-bottom:20px;
        }

        .hero a{
            background:#ff9800;
            color:white;
            padding:15px 30px;
            text-decoration:none;
            border-radius:5px;
        }

        /* PRODUCTS */

        .section-title{
            text-align:center;
            margin:50px 0 20px;
            font-size:35px;
            color:#1e1e2f;
        }

        .products{
            width:90%;
            margin:auto;

            display:grid;

            grid-template-columns:
            repeat(auto-fit,minmax(280px,1fr));

            gap:25px;

            margin-bottom:50px;
        }

        .product-card{
            background:white;
            border-radius:10px;
            overflow:hidden;
            box-shadow:0 0 10px rgba(0,0,0,0.1);

            transition:0.3s;
        }

        .product-card:hover{
            transform:translateY(-5px);
        }

        .product-card img{
            width:100%;
            height:250px;
            object-fit:cover;
        }

        .product-info{
            padding:20px;
        }

        .product-info h3{
            margin-bottom:10px;
            font-size:22px;
        }

        .price{
            color:green;
            font-size:24px;
            margin-bottom:15px;
            font-weight:bold;
        }

        .btn{
            display:inline-block;
            background:#1e1e2f;
            color:white;
            padding:12px 20px;
            text-decoration:none;
            border-radius:5px;
        }

        .btn:hover{
            background:#ff9800;
        }

        /* FOOTER */

        footer{
            background:#1e1e2f;
            color:white;
            text-align:center;
            padding:20px;
        }

        /* MOBILE */

        @media(max-width:768px){

            .navbar{
                flex-direction:column;
                gap:15px;
            }

            .hero h1{
                font-size:40px;
            }

            .hero p{
                font-size:18px;
            }

        }

    </style>

</head>
<body>

<!-- NAVBAR -->

<div class="navbar">

    <div class="logo">
        ArtCraft
    </div>

    <div class="nav-links">

        <a href="index.php">Home</a>

        <a href="products.php">Products</a>

        <?php if(isset($_SESSION['user_id'])){ ?>

            <a href="cart.php">Cart</a>

            <a href="my_orders.php">My Orders</a>

            <a href="seller_dashboard.php">
                Seller Dashboard
            </a>

            <a href="#">
                Welcome,
                <?php echo $_SESSION['user_name']; ?>
            </a>

            <a href="logout.php">Logout</a>

        <?php } else { ?>

            <a href="login.php">Login</a>

            <a href="register.php">Register</a>

        <?php } ?>

    </div>

</div>

<!-- HERO -->

<div class="hero">

    <h1>Handmade Art & Craft Marketplace</h1>

    <p>
        Buy and Sell Beautiful Handmade Products
    </p>

    <a href="products.php">
        Explore Products
    </a>

</div>

<!-- PRODUCTS -->

<h2 class="section-title">
    Latest Handmade Products
</h2>

<div class="products">

<?php while($row = mysqli_fetch_assoc($product_result)){ ?>

    <div class="product-card">

        <img src="uploads/products/<?php echo $row['product_image']; ?>">

        <div class="product-info">

            <h3>
                <?php echo $row['product_name']; ?>
            </h3>

            <p class="price">
                ₹<?php echo $row['price']; ?>
            </p>

            <a class="btn"
               href="product_details.php?id=<?php echo $row['id']; ?>">

               View Product

            </a>

        </div>

    </div>

<?php } ?>

</div>

<!-- FOOTER -->

<footer>

    <p>
        © 2026 ArtCraft Marketplace | Handmade With ❤️
    </p>

</footer>

</body>
</html>