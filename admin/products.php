<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: index.php");
    exit();
}

$query = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>All Products</title>

    <style>

        body{
            font-family:Arial;
            background:#f4f4f4;
            padding:20px;
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

        a{
            text-decoration:none;
            padding:8px 12px;
            border-radius:5px;
        }

        .add-btn{
            background:green;
            color:white;
        }

        .edit{
            background:orange;
            color:white;
        }

        .delete{
            background:red;
            color:white;
        }

    </style>

</head>
<body>

<h2>All Products</h2>

<br>

<a class="add-btn" href="add_product.php">
    Add New Product
</a>

<br><br>

<table>

<tr>
    <th>ID</th>
    <th>Image</th>
    <th>Name</th>
    <th>Price</th>
    <th>Stock</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

    <td><?php echo $row['id']; ?></td>

    <td>
        <img src="../uploads/products/<?php echo $row['product_image']; ?>">
    </td>

    <td><?php echo $row['product_name']; ?></td>

    <td>₹<?php echo $row['price']; ?></td>

    <td><?php echo $row['stock']; ?></td>

    <td>

        <a class="edit"
           href="edit_product.php?id=<?php echo $row['id']; ?>">
           Edit
        </a>

        <a class="delete"
           href="delete_product.php?id=<?php echo $row['id']; ?>">
           Delete
        </a>

    </td>

</tr>

<?php } ?>

</table>

</body>
</html>