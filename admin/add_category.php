<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: index.php");
    exit();
}

$message = "";

if(isset($_POST['add_category'])){

    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);

    $query = "INSERT INTO categories(category_name)
              VALUES('$category_name')";

    if(mysqli_query($conn, $query)){

        $message = "Category Added Successfully";

    } else {

        $message = "Failed To Add Category";

    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>

    <style>

        body{
            font-family:Arial;
            background:#f4f4f4;
        }

        .container{
            width:500px;
            background:white;
            padding:30px;
            margin:50px auto;
            border-radius:10px;
        }

        input{
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

    <h2>Add Category</h2>

    <?php if($message != ""){ ?>
        <p class="message"><?php echo $message; ?></p>
    <?php } ?>

    <form method="POST">

        <input type="text"
               name="category_name"
               placeholder="Category Name"
               required>

        <button type="submit" name="add_category">
            Add Category
        </button>

    </form>

</div>

</body>
</html>