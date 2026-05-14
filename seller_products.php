<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM products
          WHERE user_id='$user_id'
          ORDER BY id DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Products</title>

    <style>

        body{
            background:#f4f4f4;
            padding:30px;
            font-family:Arial;
        }

        h2{
            margin-bottom:20px;
        }

        .add-btn{
            display:inline-block;
            background:green;
            color:white;
            padding:12px 20px;
            text-decoration:none;
            border-radius:5px;
            margin-bottom:20px;
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

        .edit{
            background:orange;
            color:white;
            padding:8px 12px;
            text-decoration:none;
            border-radius:5px;
        }

        .delete{
            background:red;
            color:white;
            padding:8px 12px;
            text-decoration:none;
            border-radius:5px;
        }

    </style>

</head>
<body>

<h2>My Products</h2>

<a class="add-btn"
   href="seller_add_product.php">

   Add Product

</a>

<table>

<tr>

    <th>Image</th>
    <th>Name</th>
    <th>Price</th>
    <th>Stock</th>
    <th>Action</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

    <td>

        <img src="uploads/products/<?php echo $row['product_image']; ?>">

    </td>

    <td><?php echo $row['product_name']; ?></td>

    <td>₹<?php echo $row['price']; ?></td>

    <td><?php echo $row['stock']; ?></td>

    <td>

        <a class="edit"
           href="seller_edit_product.php?id=<?php echo $row['id']; ?>">

           Edit

        </a>

        <a class="delete"
           href="seller_delete_product.php?id=<?php echo $row['id']; ?>">

           Delete

        </a>

    </td>

</tr>

<?php } ?>

</table>

</body>
</html>