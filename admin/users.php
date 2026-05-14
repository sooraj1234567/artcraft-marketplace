<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: index.php");
    exit();
}

$query = "SELECT * FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Users Management</title>

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
            width:70px;
            height:70px;
            border-radius:50%;
            object-fit:cover;
        }

        .delete{
            background:red;
            color:white;
            padding:8px 12px;
            text-decoration:none;
            border-radius:5px;
        }

        .role{
            padding:5px 10px;
            border-radius:5px;
            color:white;
        }

        .customer{
            background:green;
        }

        .artist{
            background:orange;
        }

    </style>

</head>
<body>

<h2>All Users</h2>

<br>

<table>

<tr>
    <th>ID</th>
    <th>Profile</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
   <th>Account Type</th>
    <th>Joined</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

    <td><?php echo $row['id']; ?></td>

    <td>

        <?php if($row['profile_image'] != ""){ ?>

            <img src="../uploads/<?php echo $row['profile_image']; ?>">

        <?php } else { ?>

            No Image

        <?php } ?>

    </td>

    <td><?php echo $row['fullname']; ?></td>

    <td><?php echo $row['email']; ?></td>

    <td><?php echo $row['phone']; ?></td>

    <td>
<?php

$user_id = $row['id'];

$check_seller = mysqli_num_rows(

    mysqli_query(

        $conn,

        "SELECT * FROM products
         WHERE user_id='$user_id'"

    )
);

if($check_seller > 0){

    echo "Seller";

} else {

    echo "Buyer";
}

?>
        

    </td>

    <td><?php echo $row['created_at']; ?></td>

    <td>

        <a class="delete"
           href="delete_user.php?id=<?php echo $row['id']; ?>">
           Delete
        </a>

    </td>

</tr>

<?php } ?>

</table>

</body>
</html>