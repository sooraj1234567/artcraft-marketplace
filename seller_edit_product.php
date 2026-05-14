<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$id = $_GET['id'];

$query = "SELECT * FROM products
          WHERE id='$id'
          AND user_id='$user_id'";

$result = mysqli_query($conn, $query);

$product = mysqli_fetch_assoc($result);

$message = "";

if(isset($_POST['update_product'])){

    $category_id = $_POST['category_id'];

    $product_name = mysqli_real_escape_string(
        $conn,
        $_POST['product_name']
    );

    $description = mysqli_real_escape_string(
        $conn,
        $_POST['description']
    );

    $price = $_POST['price'];

    $stock = $_POST['stock'];

    /* IMAGE */

    $image_name = $_FILES['product_image']['name'];

    if($image_name != ""){

        $tmp_name = $_FILES['product_image']['tmp_name'];

        move_uploaded_file(
            $tmp_name,
            "uploads/products/" . $image_name
        );

    } else {

        $image_name = $product['product_image'];
    }

    /* UPDATE */

    $update = "UPDATE products SET

    category_id='$category_id',
    product_name='$product_name',
    description='$description',
    price='$price',
    stock='$stock',
    product_image='$image_name'

    WHERE id='$id'
    AND user_id='$user_id'
    ";

    if(mysqli_query($conn, $update)){

        header("Location: seller_products.php");

    } else {

        $message = "Update Failed";
    }
}

/* CATEGORY */

$category_query = mysqli_query(
    $conn,
    "SELECT * FROM categories"
);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>

    <style>

        body{
            background:#f4f4f4;
            font-family:Arial;
        }

        .container{
            width:600px;
            background:white;
            padding:30px;
            margin:40px auto;
            border-radius:10px;
        }

        input, textarea, select{
            width:100%;
            padding:12px;
            margin-top:12px;
        }

        img{
            width:120px;
            margin-top:15px;
            border-radius:5px;
        }

        button{
            width:100%;
            padding:14px;
            margin-top:20px;
            background:#1e1e2f;
            color:white;
            border:none;
            cursor:pointer;
        }

    </style>

</head>
<body>

<div class="container">

    <h2>Edit Product</h2>

    <form method="POST" enctype="multipart/form-data">

        <select name="category_id" required>

            <?php while($cat = mysqli_fetch_assoc($category_query)){ ?>

                <option
                value="<?php echo $cat['id']; ?>"

                <?php
                if($cat['id'] == $product['category_id'])
                echo "selected";
                ?>>

                <?php echo $cat['category_name']; ?>

                </option>

            <?php } ?>

        </select>

        <input type="text"
               name="product_name"
               value="<?php echo $product['product_name']; ?>"
               required>

        <textarea
            name="description"
            required><?php echo $product['description']; ?></textarea>

        <input type="number"
               step="0.01"
               name="price"
               value="<?php echo $product['price']; ?>"
               required>

        <input type="number"
               name="stock"
               value="<?php echo $product['stock']; ?>"
               required>

        <p>Current Image:</p>

        <img src="uploads/products/<?php echo $product['product_image']; ?>">

        <input type="file" name="product_image">

        <button type="submit" name="update_product">

            Update Product

        </button>

    </form>

</div>

</body>
</html>