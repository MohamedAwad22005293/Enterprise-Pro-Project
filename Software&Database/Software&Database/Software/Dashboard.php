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
<title>Rakusen - Dashboard</title>
<link rel="stylesheet" href="DashboardStyle.Css">
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

                if ($user_role == 'Manager' || $user_role == 'Employee') {
                    echo '<li><a href="Dashboard.php">Dashboard</a></li>';
                    echo '<li><a href="Orders.php">Orders</a></li>';
                    echo '<li><a href="Alerts.php">Alerts</a></li>';
                    echo '<li><a href="Reports.php">Reports</a></li>';
                }
            }
        ?>
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

                // Check if user is a manager and display the "Manage Users" and "Vendor Orders" link
                if ($user_role == 'Manager' || $user_role == 'Vendor' ||$user_role == 'Employee') {
                    echo '<li><a href="AccountPage.php">Account</a></li>';
                }
            }
        ?>
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

                if ($user_role == 'Manager') {
                    echo '<li><a href="Manage_users.php">Manage Users</a></li>';
                    echo '<li><a href="Book_In.php">Book Ingredients</a></li>';
                    echo '<li><a href="Approval.php">Approve Users</a></li>';
                    echo '<li><a href="Inventory.php">Inventory</a></li>';
                }
            }
        ?>
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

                if ($user_role == 'Vendor') {
                    echo '<li><a href="VendorItems.php">Vendor Orders</a></li>';
                    
                }
            }
        ?>
        <li><a href="Logout.php">Logout</a></li>
        
    </ul>
</div>

<div class="dashboard">
    <div class="content">
        <h2>Dashboard</h2>
        <p>Homepage</p>
        <div class="alerts-box">
    <h3>Alerts</h3>
            <p>
            <?php
            // Establish a database connection
            $connection = mysqli_connect($host, $username, $password, $database);

            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }

            // Get the current date
            $currentDate = date('Y-m-d');

            // Retrieve alerts from the database
            $query = "SELECT productName, productQuantity, bestBeforeDate FROM alerts WHERE productQuantity < 20 OR bestBeforeDate <= DATE_ADD('$currentDate', INTERVAL 7 DAY) LIMIT 3";
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) > 0) {
                // Display the alerts as hyperlinks leading to 'Alerts.php'
                echo '<ul>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<li><a href="Alerts.php">' . $row['productName'] . '</a></li>';
                }
                echo '</ul>';
            } else {
                echo '<p>No alerts found.</p>';
            }

            // Close the database connection
            mysqli_close($connection);
            ?>
            </p>
        </div>

        <div class="stats-box">
    <h3>Sales Statistics</h3>
    <form method="POST">
        <label for="filter">Filter:</label>
        <select name="filter" id="filter">
            <option value="week">This Week</option>
            <option value="month">This Month</option>
            <option value="quarter">This Quarter</option>
            <option value="year">This Year</option>
        </select>
        <button type="submit">Apply</button>
    </form>

    <?php
    // Establish a database connection
    $connection = mysqli_connect($host, $username, $password, $database);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Default filter value
    $filter = "";
    $filterQuery = ""; // Initialize $filterQuery variable

    // Check if filter is set
    if (isset($_POST['filter'])) {
        $filter = $_POST['filter'];

        // Construct SQL query based on filter
        switch ($filter) {
            case "week":
                $filterQuery = "AND saleDate >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
                break;
            case "month":
                $filterQuery = "AND MONTH(saleDate) = MONTH(CURDATE())";
                break;
            case "quarter":
                $quarter = ceil(date('n') / 3); // Calculate current quarter
                $filterQuery = "AND QUARTER(saleDate) = $quarter";
                break;
            case "year":
                $filterQuery = "AND YEAR(saleDate) = YEAR(CURDATE())";
                break;
            default:
                // Do nothing if no filter selected
        }
    }

    // Query to get the total number of sales based on filter
    $totalSalesQuery = "SELECT COUNT(*) AS totalSales, SUM(saleAmount) AS totalAmount FROM sales WHERE 1 $filterQuery";
    $totalSalesResult = mysqli_query($connection, $totalSalesQuery);
    $totalSalesRow = mysqli_fetch_assoc($totalSalesResult);
    $totalSales = $totalSalesRow['totalSales'];
    $totalAmount = $totalSalesRow['totalAmount'];

    // Display total number of sales and total amount
    echo "<p>Total Sales: $totalSales</p>";
    echo "<p>Total Amount: $totalAmount</p>";

    // Query to get the top 3 products and their total amount sold based on filter
    $topProductsQuery = "SELECT productName, SUM(saleAmount) AS totalAmountSold FROM sales WHERE 1 $filterQuery GROUP BY productName ORDER BY totalAmountSold DESC LIMIT 3";
    $topProductsResult = mysqli_query($connection, $topProductsQuery);

    if (mysqli_num_rows($topProductsResult) > 0) {
        // Display the top 3 products and their total amount sold
        echo "<h4>Top 3 Products Sold:</h4>";
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($topProductsResult)) {
            echo "<li>" . $row['productName'] . ": $" . $row['totalAmountSold'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No sales data available for the selected filter.</p>";
    }

    // Close the database connection
    mysqli_close($connection);
    ?>
</div>
        <div class="inventory-box">
    <h3>Current Supply</h3>
    <div class="search-bar">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search...">
            <button type="submit">Search</button>
        </form>
    </div>
            <?php
            // Check if search query is set and not empty
            if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
                echo '<div class="search-results">';
                // Establish database connection
                $connection = mysqli_connect($host, $username, $password, $database);
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                // Fetch products based on search query
                $search = mysqli_real_escape_string($connection, $_GET['search']);
                $query = "SELECT productName, productQuantity, price FROM products WHERE productName LIKE '%$search%'";
                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result) > 0) {
                    // Display search results
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<p>';
                        echo '<strong>Name:</strong> ' . $row['productName'] . ', ';
                        echo '<strong>Quantity:</strong> ' . $row['productQuantity'] . ', ';
                        echo '<strong>Price:</strong> ' . $row['price'];
                        echo '</p>';
                    }
                } else {
                    echo '<p>No products found.</p>';
                }

                // Close database connection
                mysqli_close($connection);
                echo '</div>'; // close search-results div
            } elseif (isset($_GET['search']) && empty(trim($_GET['search']))) {
                // Display message if search input is empty
                echo '<p>Please enter a search query.</p>';
            }
            ?>
        </div>


    <div class="orders-box">
    <h3>Orders Made</h3>
    <form method="POST">
        <label for="filter">Filter:</label>
        <select name="filter" id="filter">
            <option value="all">All</option>
            <option value="week">This Week</option>
            <option value="month">This Month</option>
            <option value="quarter">This Quarter</option>
            <option value="year">This Year</option>
        </select>
        <button type="submit">Apply</button>
    </form>
    <?php
    // Establish a database connection
    $connection = mysqli_connect($host, $username, $password, $database);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Default filter value
    $filter = "";
    $filterQuery = ""; // Initialize $filterQuery variable

    // Check if filter is set
    if (isset($_POST['filter'])) {
        $filter = $_POST['filter'];

        // Construct SQL query based on filter
        switch ($filter) {
            case "week":
                $filterQuery = "AND orderDate >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
                break;
            case "month":
                $filterQuery = "AND MONTH(orderDate) = MONTH(CURDATE())";
                break;
            case "quarter":
                $quarter = ceil(date('n') / 3); // Calculate current quarter
                $filterQuery = "AND QUARTER(orderDate) = $quarter";
                break;
            case "year":
                $filterQuery = "AND YEAR(orderDate) = YEAR(CURDATE())";
                break;
            default:
                $filterQuery = ""; // Show all orders
        }
    }

    // Query to get the total number of completed orders based on filter
    $query = "SELECT COUNT(*) AS totalOrders FROM orders WHERE orderStatus = 'Completed' $filterQuery";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $totalOrders = $row['totalOrders'];

    // Display total number of orders
    echo "<p>Total Completed Orders: $totalOrders</p>";

    // Close the database connection
    mysqli_close($connection);
    ?>
</div>



<div class="processing-box">
    <h3>Orders Processing</h3>
    <?php
    // Establish a database connection
    $connection = mysqli_connect($host, $username, $password, $database);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Query to get the total number of orders in processing
    $totalOrdersQuery = "SELECT COUNT(*) AS totalOrders FROM orders WHERE orderStatus = 'Processing'";
    $totalOrdersResult = mysqli_query($connection, $totalOrdersQuery);
    $totalOrdersRow = mysqli_fetch_assoc($totalOrdersResult);
    $totalOrders = $totalOrdersRow['totalOrders'];

    // Display total number of orders in processing
    echo "<p>Total Orders Processing: $totalOrders</p>";

    // Query to fetch up to three orders with orderID and bestBeforeDate if more than a week has passed
    $ordersToProcessQuery = "SELECT orderID, bestBeforeDate FROM orders WHERE orderStatus = 'Processing' AND orderDate <= DATE_SUB(NOW(), INTERVAL 1 WEEK) LIMIT 3";
    $ordersToProcessResult = mysqli_query($connection, $ordersToProcessQuery);

    if (mysqli_num_rows($ordersToProcessResult) > 0) {
        // Display the orders to process
        echo "<h4>Orders to process:</h4>";
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($ordersToProcessResult)) {
            echo "<li>Order ID: " . $row['orderID'] . ", Best Before Date: " . $row['bestBeforeDate'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No orders require processing at the moment.</p>";
    }

    // Close the database connection
    mysqli_close($connection);
    ?>
</div>

</div>
<footer class="footer">
    <p>&copy; 2024 Rakusen. All rights reserved.</p>
</footer>
<script>
    // Get the current date
    var currentDate = new Date();

    // Format the date as desired (e.g., dd-mm-yyyy)
    var day = currentDate.getDate();
    var month = currentDate.getMonth() + 1; // Months are zero-based
    var year = currentDate.getFullYear();

    // Display the date in the designated HTML element
    document.getElementById("currentDate").innerHTML = "Today's Date: " + day + "-" + month + "-" + year;
</script>
</body>
</html>