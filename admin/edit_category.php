<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

$query = "SELECT * FROM categories WHERE id='$id'";
$result = mysqli_query($conn, $query);
$category = mysqli_fetch_assoc($result);

if(isset($_POST['update_category'])){

    $category_name = mysqli_real_escape_string(
        $conn,
        $_POST['category_name']
    );

    $update = "UPDATE categories 
               SET category_name='$category_name'
               WHERE id='$id'";

    if(mysqli_query($conn, $update)){

        header("Location: categories.php");

    } else {

        echo "Update Failed";

    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>

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

    </style>

</head>
<body>

<div class="container">

    <h2>Edit Category</h2>

    <form method="POST">

        <input type="text"
               name="category_name"
               value="<?php echo $category['category_name']; ?>"
               required>

        <button type="submit" name="update_category">
            Update Category
        </button>

    </form>

</div>

</body>
</html>