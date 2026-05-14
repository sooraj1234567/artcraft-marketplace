<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: index.php");
    exit();
}

$message = "";

$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_query);

if(isset($_POST['add_product'])){

    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $image_name = $_FILES['product_image']['name'];
    $tmp_name = $_FILES['product_image']['tmp_name'];

    $folder = "../uploads/products/" . $image_name;

    move_uploaded_file($tmp_name, $folder);

   $query = "INSERT INTO products 

(category_id, product_name, description, price, stock, product_image, status)

VALUES

('$category_id', '$product_name', '$description', '$price', '$stock', '$image_name', 'approved')";

    if(mysqli_query($conn, $query)){
        $message = "Product Added Successfully";
    } else {
        $message = "Failed To Add Product";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>

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

        button{
            width:100%;
            padding:12px;
            margin-top:15px;
            background:#1e1e2f;
            color:white;
            border:none;
            cursor:pointer;
        }

        .message{
            text-align:center;
            color:green;
        }

    </style>

</head>
<body>

<div class="container">

    <h2>Add Product</h2>

    <?php if($message != ""){ ?>
        <p class="message"><?php echo $message; ?></p>
    <?php } ?>

    <form method="POST" enctype="multipart/form-data">

        <input type="text"
               name="product_name"
               placeholder="Product Name"
               required>

        <textarea name="description"
                  placeholder="Product Description"
                  required></textarea>
<select name="category_id" required
style="width:100%; padding:12px; margin-top:10px;">

    <option value="">Select Category</option>

    <?php while($cat = mysqli_fetch_assoc($category_result)){ ?>

        <option value="<?php echo $cat['id']; ?>">
            <?php echo $cat['category_name']; ?>
        </option>

    <?php } ?>

</select>

        <input type="number"
               step="0.01"
               name="price"
               placeholder="Price"
               required>

        <input type="number"
               name="stock"
               placeholder="Stock Quantity"
               required>

        <input type="file"
               name="product_image"
               required>

        <button type="submit" name="add_product">
            Add Product
        </button>

    </form>

</div>

</body>
</html>