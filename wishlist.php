<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* GET WISHLIST */

$query = "

SELECT wishlist.*,
products.product_name,
products.price,
products.product_image

FROM wishlist

JOIN products
ON wishlist.product_id = products.id

WHERE wishlist.user_id='$user_id'

ORDER BY wishlist.id DESC

";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Wishlist</title>

    <style>

        body{
            background:#f4f4f4;
            font-family:Arial;
            padding:30px;
        }

        h2{
            margin-bottom:25px;
        }

        .wishlist{
            display:grid;

            grid-template-columns:
            repeat(auto-fit,minmax(250px,1fr));

            gap:20px;
        }

        .card{
            background:white;
            border-radius:10px;
            overflow:hidden;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }

        .card img{
            width:100%;
            height:250px;
            object-fit:cover;
        }

        .info{
            padding:15px;
        }

        .price{
            color:green;
            font-size:22px;
            margin:10px 0;
        }

        .btn{
            display:inline-block;
            padding:10px 18px;
            text-decoration:none;
            border-radius:5px;
            color:white;
        }

        .cart{
            background:#1e1e2f;
        }

        .remove{
            background:red;
            margin-left:10px;
        }

    </style>

</head>
<body>

<h2>My Wishlist ❤️</h2>

<div class="wishlist">

<?php while($row = mysqli_fetch_assoc($result)){ ?>

    <div class="card">

        <img src="uploads/products/<?php echo $row['product_image']; ?>">

        <div class="info">

            <h3>
                <?php echo $row['product_name']; ?>
            </h3>

            <p class="price">
                ₹<?php echo $row['price']; ?>
            </p>

            <a class="btn cart"

               href="product_details.php?id=<?php echo $row['product_id']; ?>">

               View

            </a>

            <a class="btn remove"

               href="remove_wishlist.php?id=<?php echo $row['id']; ?>">

               Remove

            </a>

        </div>

    </div>

<?php } ?>

</div>

</body>
</html>