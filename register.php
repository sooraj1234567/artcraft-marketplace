<?php
include("config/db.php");

$message = "";

if(isset($_POST['register'])){

    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password'];
    

    // Check Email

    $check = mysqli_query(
        $conn,
        "SELECT * FROM users WHERE email='$email'"
    );

    if(mysqli_num_rows($check) > 0){

        $message = "Email Already Exists";

    } else {

        $query = "INSERT INTO users
        (fullname, email, phone, password)

        VALUES

        ('$fullname', '$email', '$phone', '$password')";

        if(mysqli_query($conn, $query)){

            $message = "Registration Successful";

        } else {

            $message = "Registration Failed";

        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>

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
            margin:50px auto;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }

        h2{
            text-align:center;
            margin-bottom:20px;
            color:#1e1e2f;
        }

        input, select{
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
            margin-bottom:15px;
            color:green;
        }

        .login-link{
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

    <h2>Create Account</h2>

    <?php if($message != ""){ ?>

        <p class="message">
            <?php echo $message; ?>
        </p>

    <?php } ?>

    <form method="POST">

        <input type="text"
               name="fullname"
               placeholder="Full Name"
               required>

        <input type="email"
               name="email"
               placeholder="Email Address"
               required>

        <input type="text"
               name="phone"
               placeholder="Phone Number"
               required>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        
        <button type="submit" name="register">
            Register
        </button>

    </form>

    <div class="login-link">

        Already have account?

        <a href="login.php">
            Login
        </a>

    </div>

</div>

</body>
</html>