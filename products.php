
<?php
session_start();
include("config/db.php");

/* GET ALL PRODUCTS */

$search = "";

$category = "";

/* SEARCH */

if(isset($_GET['search'])){

    $search = mysqli_real_escape_string(
        $conn,
        $_GET['search']
    );
}

/* CATEGORY */

if(isset($_GET['category'])){

    $category = $_GET['category'];
}

/* QUERY */

$product_query = "

SELECT * FROM products

WHERE 1

";

/* SEARCH FILTER */

if($search != ""){

    $product_query .= "

    AND product_name LIKE '%$search%'

    ";
}

/* CATEGORY FILTER */

if($category != ""){

    $product_query .= "

    AND category_id='$category'

    ";
}

/* ORDER */

$product_query .= "

ORDER BY id DESC

";

/* RUN */

$product_result = mysqli_query($conn, $product_query);

/* CATEGORIES */

$category_query = mysqli_query(
    $conn,
    "SELECT * FROM categories"
);

$product_result = mysqli_query($conn, $product_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Products</title>

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
        }

        .nav-links a:hover{
            color:#ff9800;
        }

        /* PAGE TITLE */

        .title{
            text-align:center;
            margin:40px 0;
            font-size:40px;
            color:#1e1e2f;
        }

        /* PRODUCTS */

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
            margin-top:40px;
        }

        /* SEARCH BOX */

.search-box{
    width:90%;
    margin:20px auto;
    background:white;
    padding:20px;
    border-radius:10px;
}

.search-box form{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.search-box input,
.search-box select{
    flex:1;
    padding:14px;
    border:1px solid #ddd;
    border-radius:5px;
    font-size:16px;
}

.search-box button{
    padding:14px 25px;
    background:#1e1e2f;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.search-box button:hover{
    background:#ff9800;
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
<a href="wishlist.php">

    Wishlist

</a>
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

<!-- TITLE -->

<h1 class="title">
    All Handmade Products
</h1>

<!-- SEARCH -->

<div class="search-box">

    <form method="GET">

        <input
            type="text"
            name="search"
            placeholder="Search products..."
            value="<?php echo $search; ?>">

        <select name="category">

            <option value="">
                All Categories
            </option>

            <?php while($cat = mysqli_fetch_assoc($category_query)){ ?>

                <option

                value="<?php echo $cat['id']; ?>"

                <?php
                if($category == $cat['id'])
                echo "selected";
                ?>>

                <?php echo $cat['category_name']; ?>

                </option>

            <?php } ?>

        </select>

        <button type="submit">

            Search

        </button>

    </form>

</div>

<!-- PRODUCTS -->

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

            <a class="btn"

href="add_to_wishlist.php?id=<?php echo $row['id']; ?>">

❤️ Wishlist

</a>

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
```

