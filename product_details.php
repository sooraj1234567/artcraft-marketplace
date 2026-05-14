<?php
session_start();
include("config/db.php");

$id = $_GET['id'];

$query = "SELECT * FROM products WHERE id='$id'";
$result = mysqli_query($conn, $query);

$product = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Details</title>

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

        .container{
            width:90%;
            max-width:1100px;

            background:white;

            margin:50px auto;

            display:flex;
            gap:40px;

            padding:30px;

            border-radius:10px;

            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }

        .product-image{
            flex:1;
        }

        .product-image img{
            width:100%;
            height:500px;
            object-fit:cover;
            border-radius:10px;
        }

        .product-details{
            flex:1;
        }

        .product-details h1{
            font-size:40px;
            margin-bottom:20px;
            color:#1e1e2f;
        }

        .price{
            font-size:35px;
            color:green;
            margin-bottom:20px;
            font-weight:bold;
        }

        .description{
            font-size:18px;
            line-height:1.7;
            margin-bottom:30px;
            color:#444;
        }

        .stock{
            margin-bottom:20px;
            font-size:18px;
        }

        .btn{
            display:inline-block;

            background:#1e1e2f;
            color:white;

            padding:15px 30px;

            text-decoration:none;

            border-radius:5px;

            font-size:18px;
        }

        .btn:hover{
            background:#ff9800;
        }

        @media(max-width:768px){

            .container{
                flex-direction:column;
            }

        }

    </style>

</head>
<body>

<div class="container">

    <div class="product-image">

        <img src="uploads/products/<?php echo $product['product_image']; ?>">

    </div>

    <div class="product-details">

        <h1>
            <?php echo $product['product_name']; ?>
        </h1>

        <p class="price">
            ₹<?php echo $product['price']; ?>
        </p>

        <p class="description">
            <?php echo $product['description']; ?>
        </p>

        <p class="stock">

            Available Stock:
            <?php echo $product['stock']; ?>

        </p>

        <?php if(isset($_SESSION['user_id'])){ ?>

            <a class="btn"
               href="add_to_cart.php?id=<?php echo $product['id']; ?>">

               Add To Cart

            </a>

        <?php } else { ?>

            <a class="btn" href="login.php">

                Login To Buy

            </a>

        <?php } ?>

    </div>

</div>

</body>
</html>