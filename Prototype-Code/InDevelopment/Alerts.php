<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rakusen - Alerts</title>
<link rel="stylesheet" href="AlertsStyle.Css">
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
                    echo '<li><a href="Manage_users.php">Manage Users</a></li>';
                }
            }
        ?>
        <li><a href="Login.html">Logout</a></li>
    </ul>
</div>

<div class="dashboard">
    <div class="content">
        <h2>Alerts</h2>

        <div class="button-group">
            <button type="button">Data Range</button>
            <button type="button">Alerts Type</button>
        </div>

        <div class="search-bar">
            <input type="text" placeholder="Search...">
            <button type="button">Search</button>
        </div>
        
        <div class="container">
            <div class="row">
                <div class="box bold-text">Item Name</div>
                <div class="box bold-text">SKU Code</div>
                <div class="box bold-text">Alert Type</div>
                <div class="box bold-text">Quantity</div>
                <div class="box bold-text">Updated Count</div>
                <div class="box bold-text">Best Before Date (BBD)</div>
            </div>
            <div class="row">
                <div class="box">Product 1</div>
                <div class="box">SKU001</div>
                <div class="box">Low Stock</div>
                <div class="box">50</div>
                <div class="box"></div>
                <div class="box">2024-03-10</div>
            </div>
            <div class="row">
                <div class="box">Product 1</div>
                <div class="box">SKU001</div>
                <div class="box">Low Stock</div>
                <div class="box">50</div>
                <div class="box"></div>
                <div class="box">2024-03-10</div>
            </div>
            <div class="row">
                <div class="box">Product 1</div>
                <div class="box">SKU001</div>
                <div class="box">Low Stock</div>
                <div class="box">50</div>
                <div class="box"></div>
                <div class="box">2024-03-10</div>
            </div>
            <div class="row">
                <div class="box">Product 1</div>
                <div class="box">SKU001</div>
                <div class="box">Low Stock</div>
                <div class="box">50</div>
                <div class="box"></div>
                <div class="box">2024-03-10</div>
            </div>
            <div class="row">
                <div class="box">Product 1</div>
                <div class="box">SKU001</div>
                <div class="box">Low Stock</div>
                <div class="box">50</div>
                <div class="box"></div>
                <div class="box">2024-03-10</div>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <p>&copy; 2024 Rakusen. All rights reserved.</p>
</footer>

</body>
</html>
