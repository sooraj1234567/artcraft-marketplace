<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: index.php");
    exit();
}

$query = "SELECT * FROM users 
          WHERE role='artist'
          ORDER BY id DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Artists Management</title>

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

        .status{
            padding:6px 12px;
            color:white;
            border-radius:5px;
        }

        .pending{
            background:orange;
        }

        .approved{
            background:green;
        }

        .rejected{
            background:red;
        }

        .btn{
            background:#1e1e2f;
            color:white;
            padding:8px 12px;
            text-decoration:none;
            border-radius:5px;
        }

    </style>

</head>
<body>

<h2>Artists Management</h2>

<br>

<table>

<tr>

    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Status</th>
    <th>Joined</th>
    <th>Action</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

    <td><?php echo $row['id']; ?></td>

    <td><?php echo $row['fullname']; ?></td>

    <td><?php echo $row['email']; ?></td>

    <td><?php echo $row['phone']; ?></td>

    <td>

        <span class="status <?php echo $row['seller_status']; ?>">

            <?php echo ucfirst($row['seller_status']); ?>

        </span>

    </td>

    <td><?php echo $row['created_at']; ?></td>

    <td>

        <a class="btn"
           href="update_artist.php?id=<?php echo $row['id']; ?>">
           Manage
        </a>

    </td>

</tr>

<?php } ?>

</table>

</body>
</html>