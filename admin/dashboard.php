<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: index.php");
    exit();
}

/* TOTAL PRODUCTS */

$product_count = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM products")
);

/* TOTAL USERS */

$user_count = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM users")
);

/* TOTAL ORDERS */

$order_count = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM orders")
);

/* TOTAL SELLERS */

$seller_result = mysqli_query(

    $conn,

    "SELECT user_id
     FROM products
     GROUP BY user_id"
);

$seller_count = mysqli_num_rows($seller_result);

/* TOTAL REVENUE */

$revenue_query = mysqli_query(

    $conn,

    "SELECT SUM(total_amount) AS revenue
     FROM orders
     WHERE payment_status='paid'"
);

$revenue_data = mysqli_fetch_assoc($revenue_query);

$total_revenue = $revenue_data['revenue'];

if($total_revenue == ""){
    $total_revenue = 0;
}

/* MONTHLY SALES */

$monthly_sales = [];

$months = [];

for($i = 1; $i <= 12; $i++){

    $month_name = date("M", mktime(0,0,0,$i,10));

    $months[] = $month_name;

    $sales_query = mysqli_query(

        $conn,

        "SELECT SUM(total_amount) AS total

         FROM orders

         WHERE MONTH(created_at) = '$i'
         AND payment_status='paid'"
    );

    $sales_data = mysqli_fetch_assoc($sales_query);

    $monthly_sales[] = $sales_data['total'] ?? 0;
}

/* ORDER STATUS COUNTS */

$pending_count = mysqli_num_rows(

    mysqli_query(
        $conn,
        "SELECT * FROM orders
         WHERE order_status='pending'"
    )
);

$processing_count = mysqli_num_rows(

    mysqli_query(
        $conn,
        "SELECT * FROM orders
         WHERE order_status='processing'"
    )
);

$shipped_count = mysqli_num_rows(

    mysqli_query(
        $conn,
        "SELECT * FROM orders
         WHERE order_status='shipped'"
    )
);

$delivered_count = mysqli_num_rows(

    mysqli_query(
        $conn,
        "SELECT * FROM orders
         WHERE order_status='delivered'"
    )
);

$cancelled_count = mysqli_num_rows(

    mysqli_query(
        $conn,
        "SELECT * FROM orders
         WHERE order_status='cancelled'"
    )
);

/* RECENT ORDERS */

$recent_orders = mysqli_query(

    $conn,

    "SELECT orders.*, users.fullname

     FROM orders

     JOIN users
     ON orders.user_id = users.id

     ORDER BY orders.id DESC

     LIMIT 5"
);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial;
        }

        body{
            display:flex;
            background:#f4f4f4;
        }

        /* SIDEBAR */

        .sidebar{
            width:250px;
            height:100vh;
            background:#1e1e2f;
            color:white;
            padding:20px;
            position:fixed;
        }

        .sidebar h2{
            text-align:center;
            margin-bottom:30px;
        }

        .sidebar ul{
            list-style:none;
        }

        .sidebar ul li{
            margin:15px 0;
        }

        .sidebar ul li a{
            color:white;
            text-decoration:none;
            display:block;
            padding:12px;
            border-radius:5px;
            transition:0.3s;
        }

        .sidebar ul li a:hover{
            background:#34344a;
        }

        /* MAIN */

        .main{
            margin-left:250px;
            width:100%;
            padding:20px;
        }

        .header{
            background:white;
            padding:20px;
            border-radius:10px;
            margin-bottom:20px;
        }

        /* CARDS */

        .cards{
            display:grid;

            grid-template-columns:
            repeat(auto-fit,minmax(220px,1fr));

            gap:20px;
        }

        .card{
            background:white;
            padding:30px;
            border-radius:10px;
            text-align:center;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }

        .card h1{
            font-size:35px;
            margin-bottom:10px;
            color:#1e1e2f;
        }

        .card p{
            color:gray;
            font-size:18px;
        }

        /* BOX */

        .box{
            margin-top:30px;
            background:white;
            padding:20px;
            border-radius:10px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:15px;
        }

        th, td{
            padding:12px;
            border:1px solid #ddd;
            text-align:center;
        }

        th{
            background:#1e1e2f;
            color:white;
        }

        .charts{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:20px;
            margin-top:30px;
        }

        @media(max-width:900px){

            .charts{
                grid-template-columns:1fr;
            }
        }

    </style>

</head>
<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <h2>Admin Panel</h2>

    <ul>

        <li><a href="dashboard.php">Dashboard</a></li>

        <li><a href="products.php">Products</a></li>

        <li><a href="categories.php">Categories</a></li>

        <li><a href="users.php">Users</a></li>

        <li><a href="orders.php">Orders</a></li>

        <li><a href="logout.php">Logout</a></li>

    </ul>

</div>

<!-- MAIN -->

<div class="main">

    <!-- HEADER -->

    <div class="header">

        <h1>

            Welcome,
            <?php echo $_SESSION['admin_name']; ?> 👋

        </h1>

    </div>

    <!-- CARDS -->

    <div class="cards">

        <div class="card">

            <h1><?php echo $product_count; ?></h1>

            <p>Total Products</p>

        </div>

        <div class="card">

            <h1><?php echo $user_count; ?></h1>

            <p>Total Users</p>

        </div>

        <div class="card">

            <h1><?php echo $seller_count; ?></h1>

            <p>Total Sellers</p>

        </div>

        <div class="card">

            <h1><?php echo $order_count; ?></h1>

            <p>Total Orders</p>

        </div>

        <div class="card">

            <h1>₹<?php echo $total_revenue; ?></h1>

            <p>Total Revenue</p>

        </div>

    </div>

    <!-- CHARTS -->

    <div class="charts">

        <!-- SALES CHART -->

        <div class="box">

            <h2>Sales Analytics</h2>

            <canvas id="salesChart"></canvas>

        </div>

        <!-- PIE CHART -->

        <div class="box">

            <h2>Order Status Analytics</h2>

            <canvas id="orderChart"></canvas>

        </div>

    </div>

    <!-- RECENT ORDERS -->

    <div class="box">

        <h2>Recent Orders</h2>

        <table>

            <tr>

                <th>Order ID</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Status</th>

            </tr>

            <?php while($row = mysqli_fetch_assoc($recent_orders)){ ?>

            <tr>

                <td>#<?php echo $row['id']; ?></td>

                <td><?php echo $row['fullname']; ?></td>

                <td>₹<?php echo $row['total_amount']; ?></td>

                <td><?php echo ucfirst($row['order_status']); ?></td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

<script>

/* SALES CHART */

const ctx = document.getElementById('salesChart');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: <?php echo json_encode($months); ?>,

        datasets: [{

            label: 'Monthly Revenue',

            data: <?php echo json_encode($monthly_sales); ?>,

            borderWidth: 3,

            tension: 0.4

        }]
    },

    options: {

        responsive: true,

        scales: {

            y: {

                beginAtZero: true
            }
        }
    }
});

/* PIE CHART */

const orderCtx = document.getElementById('orderChart');

new Chart(orderCtx, {

    type: 'pie',

    data: {

        labels: [

            'Pending',
            'Processing',
            'Shipped',
            'Delivered',
            'Cancelled'

        ],

        datasets: [{

            data: [

                <?php echo $pending_count; ?>,
                <?php echo $processing_count; ?>,
                <?php echo $shipped_count; ?>,
                <?php echo $delivered_count; ?>,
                <?php echo $cancelled_count; ?>

            ]

        }]
    },

    options: {

        responsive:true

    }
});

</script>

</body>
</html>