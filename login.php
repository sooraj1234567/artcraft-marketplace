<?php
session_start();
include("config/db.php");

$message = "";

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users
              WHERE email='$email'
              AND password='$password'";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){

        $user = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['fullname'];
        $_SESSION['user_role'] = $user['role'];

        header("Location: index.php");

    } else {

        $message = "Invalid Email or Password";

    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>

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

        .container{
            width:450px;
            background:white;
            padding:30px;
            margin:80px auto;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }

        h2{
            text-align:center;
            margin-bottom:20px;
            color:#1e1e2f;
        }

        input{
            width:100%;
            padding:12px;
            margin-top:12px;
        }

        button{
            width:100%;
            padding:12px;
            margin-top:20px;
            background:#1e1e2f;
            color:white;
            border:none;
            cursor:pointer;
            border-radius:5px;
        }

        .message{
            text-align:center;
            color:red;
            margin-bottom:10px;
        }

        .register-link{
            text-align:center;
            margin-top:15px;
        }

        a{
            text-decoration:none;
            color:#1e1e2f;
        }

    </style>

</head>
<body>

<div class="container">

    <h2>User Login</h2>

    <?php if($message != ""){ ?>

        <p class="message">
            <?php echo $message; ?>
        </p>

    <?php } ?>

    <form method="POST">

        <input type="email"
               name="email"
               placeholder="Email Address"
               required>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        <button type="submit" name="login">
            Login
        </button>

    </form>

    <div class="register-link">

        Don't have account?

        <a href="register.php">
            Register
        </a>

    </div>

</div>

</body>
</html>