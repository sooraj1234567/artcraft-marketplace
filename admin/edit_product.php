<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

$query = "SELECT * FROM products WHERE id='$id'";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

$message = "";

if(isset($_POST['update_product'])){

    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $image_name = $_FILES['product_image']['name'];

    if($image_name != ""){

        $tmp_name = $_FILES['product_image']['tmp_name'];

        move_uploaded_file(
            $tmp_name,
            "../uploads/products/" . $image_name
        );

    } else {

        $image_name = $product['product_image'];

    }

    $update = "UPDATE products SET

    product_name='$product_name',
    description='$description',
    price='$price',
    stock='$stock',
    product_image='$image_name'

    WHERE id='$id'
    ";

    if(mysqli_query($conn, $update)){

        header("Location: products.php");

    } else {

        $message = "Failed To Update Product";

    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>

    <style>

        body{
            font-family:Arial;
            background:#f4f4f4;
        }

        .container{
            width:600px;
            background:white;
            padding:30px;
            margin:40px auto;
            border-radius:10px;
        }

        input, textarea{
            width:100%;
            padding:12px;
            margin-top:10px;
        }

        img{
            width:120px;
            margin-top:10px;
        }

        button{
            width:100%;
            padding:12px;
            margin-top:15px;
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

        <input type="text"
               name="product_name"
               value="<?php echo $product['product_name']; ?>"
               required>

        <textarea name="description"
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

        <img src="../uploads/products/<?php echo $product['product_image']; ?>">

        <input type="file" name="product_image">

        <button type="submit" name="update_product">
            Update Product
        </button>

    </form>

</div>

</body>
</html>