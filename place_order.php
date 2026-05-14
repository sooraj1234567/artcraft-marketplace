<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

if(isset($_POST['place_order'])){

    $user_id = $_SESSION['user_id'];

    $total_amount = $_POST['total_amount'];

    $shipping_address = mysqli_real_escape_string(
        $conn,
        $_POST['shipping_address']
    );

    // INSERT ORDER

    $order_query = "INSERT INTO orders

    (user_id, total_amount, shipping_address)

    VALUES

    ('$user_id', '$total_amount', '$shipping_address')";

    mysqli_query($conn, $order_query);

    $order_id = mysqli_insert_id($conn);

    // GET CART ITEMS

    $cart_query = mysqli_query(
        $conn,
        "SELECT * FROM cart WHERE user_id='$user_id'"
    );

    while($cart = mysqli_fetch_assoc($cart_query)){

        $product_id = $cart['product_id'];

        $quantity = $cart['quantity'];

        // GET PRODUCT PRICE

        $product_query = mysqli_query(
            $conn,
            "SELECT * FROM products WHERE id='$product_id'"
        );

        $product = mysqli_fetch_assoc($product_query);

        $price = $product['price'];

        // INSERT ORDER ITEMS

        mysqli_query(
            $conn,

            "INSERT INTO order_items

            (order_id, product_id, quantity, price)

            VALUES

            ('$order_id', '$product_id', '$quantity', '$price')"
        );

        // UPDATE STOCK

        mysqli_query(
            $conn,

            "UPDATE products

             SET stock = stock - $quantity

             WHERE id='$product_id'"
        );
    }

    // CLEAR CART

    mysqli_query(
        $conn,
        "DELETE FROM cart WHERE user_id='$user_id'"
    );

    header("Location: my_orders.php");
}
?>