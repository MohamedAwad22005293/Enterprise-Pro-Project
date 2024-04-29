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
<title>Rakusen - Vendor Order Page</title>
<link rel="stylesheet" href="VItemStyle.css">
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
        <li><a href="AccountPage.php">Account</a></li>
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
                    echo '<li><a href="VendorItems.php">Vendor Orders</a></li>';
                    echo '<li><a href="Manage_users.php">Manage Users</a></li>';
                }

            }
        ?>
        <li><a href="Logout.php">Logout</a></li>
    </ul>
</div>


<div class = "VItems">
            <h2>Vendor Orders</h2>

            <?php

            // Check if the user is logged in and retrieve their role from the database
            if (isset($_SESSION['user_email'])) {
                // Establish database connection (replace with your connection code)
                $connection = mysqli_connect($host, $username, $password, $database);

                // Check if connection was successful
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                $query = "SELECT * 
                FROM products";

                $result = mysqli_query($connection, $query);


                if ($result && mysqli_num_rows($result) > 0) {
                    // Output table header
                    echo "<table>";
                    echo "<tr> <th>Product Name</th> <th>Product Code</th> <th>SKU Code</th> <th>Quantity</th> <th>Unit Price</th> <th>Stock Status</th> <th></th></tr>";
                
                    // Output data 
                    while ($column = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $column['productName'] . "</td>";
                        echo "<td>" . $column['productCode'] . "</td>";
                        echo "<td>" . $column['skuCode'] . "</td>";
                        echo "<td>" . $column['productQuantity'] . "</td>";
                        echo "<td>" . $column['price'] . "</td>";
                        echo "<td>" . $column['orderStatus'] . "</td>";
                        echo "<td><button onclick=\"addToBasket('" . $column['productCode'] . "')\">Add to Basket</button></td>";
                        echo "</tr>";
                    }
                
                    echo "</table>";
                } else {
                    echo "No data found.";
                }
                
                // Close database connection
                mysqli_close($connection);
            }
                ?>

        </div>
        <footer class="footer">
                <p>&copy; 2024 Rakusen. All rights reserved.</p>
                </footer>
                </body>
                </html>
