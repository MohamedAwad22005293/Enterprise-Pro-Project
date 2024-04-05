<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    // Redirect to login page if not logged in
    header("Location: Login.html");
    exit();
}


// Establish a database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "rwsdb";

$connection = mysqli_connect($host, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rakusen - Orders</title>
<link rel="stylesheet" href="OrdersStyle.Css">
</head>
<body>

<div class="top-bar">
    <div class="top-left">
        <img src="rakusen.png" alt="Company Logo" class="logo">
    </div>
    <div class="middle-section">
        <h1>Rakusen Warehouse</h1>
    </div>
    <div class="top-right">
        <a href="ContactUsPage.html" style="color: rgb(0, 0, 0);">Contact Us</a>
    </div>
</div>

<div class="navbar">
    <ul>
        <li><a href="Dashboard.php">Dashboard</a></li>
        <li><a href="Inventory.php">Inventory</a></li>
        <li><a href="Orders.php">Orders</a></li>
        <li><a href="Alerts.php">Alerts</a></li>
        <li><a href="Reports.php">Reports</a></li>
        <li><a href="AccountPage.php">Account</a><li>
        <?php 
            // Check if the user is logged in and retrieve their role from the database
            if (isset($_SESSION['user_email'])) {
                // Establish database connection (replace with your connection code)
                $connection = mysqli_connect($host, $username, $password, $database);

                // Check if connection was successful
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                // Retrieve user's role from the database
                $user_email = $_SESSION['user_email'];
                $query = "SELECT role FROM users WHERE email = '$user_email'";
                $result = mysqli_query($connection, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $user_role = $row['role'];
                }

                // Close database connection
                mysqli_close($connection);

                // Check if user is a manager and display the "Manage Users" link
                if ($user_role == 'Manager') {
                    echo '<li><a href="Manage_users.php">Manage Users</a></li>';
                }
            }
        ?>
        <li><a href="Logout.php">Logout</a></li>
    </ul>
</div>

<div class="dashboard">
    <div class="content">
        <h2>Orders</h2>

        <div class="search-bar">
            <input type="text" id="nameSearch" placeholder="Search by client name">
            <input type="text" id="codeSearch" placeholder="Search by Order ID">
        </div>
        <div class="order-box">
            <div class="order-actions">
                <h3>Order 1</h3>
                <div>
                    <button class="check-btn">Check Details</button>
                    <button class="delete-btn">Delete</button>
                </div>
                <div class="order-details" style="display: none;"></div>
            </div>
            <p>Order ID: 123456</p>
            <p>Vendor ID: 000001</p>
            <p>Client Name: *******</p>
            <p>Description: Description of Order</p>
            <p>Subtotal: $19.99</p>
            <p>Status: In stock</p>
            <p>Total Product Units: 50</p>
            <p>Order Date: 2024-06-13</p>
        </div>
    </div>
</div>

<footer class="footer">
    <p>&copy; 2024 Rakusen. All rights reserved.</p>
</footer>
<script>
    // JavaScript for toggling order details on button click
    document.querySelectorAll('.check-btn').forEach(item => {
        item.addEventListener('click', event => {
            const orderBox = event.target.closest('.order-box');
            const orderDetails = orderBox.querySelector('.order-details');
            const currentHeight = orderBox.offsetHeight;
            const orderDetailsDisplay = window.getComputedStyle(orderDetails).display;

            if (orderDetailsDisplay === 'none') {
                orderDetails.style.display = 'block';
                const newHeight = orderDetails.offsetHeight + currentHeight;
                orderBox.style.height = newHeight + 'px';
            } else {
                orderDetails.style.display = 'none';
                orderBox.style.height = 'auto'; 
            }
        });
    });
</script>
</body>
</html>