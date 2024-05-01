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
<title>Rakusen - Book-in</title>
<link rel="stylesheet" href="Manage_usersStyle.Css">
<style>

    .user-box {
        overflow-x: auto;
        white-space: nowrap;
    }
</style>

</head>
<body>

<div class="top-bar">
    <div class="top-left">
        <img src="rakusen.png" alt="Company Logo" class="logo">
    </div>
    <div class="middle-section" style="padding-left: 255px;" >
        <h1>Rakusen Warehouse</h1>
    </div>
    <div class="top-right">
        <a href="Basketpage.html" style="color: rgb(0, 0, 0); margin-right: 15px;">Basket</a>
        <a href="ContactUsPage.html" style="color: rgb(0, 0, 0);">Contact Us</a>
    </div>
</div>
<div class="dashboard">
    <div class="content">
        <h2>Book-in Raw Ingredients</h2>
        <?php

        // Fetch raw ingredients from the database
        $query = "SELECT * FROM rawingredients";
        $result = @mysqli_query($connection, $query); // Use "@" to suppress error messages

        // Check if the query was successful
        if ($result === false) {
            // Handle the error gracefully
            echo "Error fetching raw ingredients. Please try again later."; // Display a user-friendly message
        } else {
            // Check if any raw ingredients are found
            if (mysqli_num_rows($result) > 0) {
                // Your existing code to iterate over the results
            } else {
                echo "No raw ingredients found.";
            }
        }
        

        // Check if any raw ingredients are found
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='user-box'>
                        <form action='saveRawIngredient.php' method='POST' enctype='multipart/form-data'>
                            <table>
                                <tr>
                                    <th>Ingredient Name</th>
                                    <th>Supplier Name</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Arrival Time</th>
                                    <th>Batch Number</th>
                                    <th>Expiry Date</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                                <tr>
                                    <td><input type='text' name='ingredient_name' value='" . $row['ingredient_name'] . "'></td>
                                    <td><input type='text' name='supplier_name' value='" . $row['supplier_name'] . "'></td>
                                    <td><input type='text' name='quantity' value='" . $row['quantity'] . "'></td>
                                    <td><input type='text' name='unit' value='" . $row['unit'] . "'></td>
                                    <td><input type='text' name='arrival_time' value='" . $row['arrival_time'] . "'></td>
                                    <td><input type='text' name='batch_number' value='" . $row['batch_number'] . "'></td>
                                    <td><input type='text' name='expiry_date' value='" . $row['expiry_date'] . "'></td>
                                    <td><input type='text' name='notes' value='" . $row['notes'] . "'></td>
                                    <td class='actions'>
                                        <form action='saveRawIngredient.php' method='POST'> <!-- Form for saving raw ingredient -->
                                            <input type='hidden' name='ingredient_id' value='" . $row['ingredient_id'] . "'>
                                            <button type='submit'>Save</button>
                                        </form>
                                        <form action='deleteRawIngredient.php' method='POST'> <!-- Form for deleting raw ingredient -->
                                            <input type='hidden' name='ingredient_id' value='" . $row['ingredient_id'] . "'>
                                            <button type='submit' name='delete_ingredient'>Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>";
            }
        } else {
            echo "No raw ingredients found.";
        }
        ?>
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

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Product Booking Page for Managers</title>
<link rel="stylesheet" href="BookinStyle.css">
</head>
<body>

<div class="container">
    <h2>Product Booking (Manager's View)</h2>
    <form action="#" method="post">
        <label for="product">Select Product:</label>
        <select name="product" id="product">
            <option value="Aromatic and long-grain Basmati rice">Aromatic and long-grain Basmati rice</option>
            <option value="Eggs (Large)">Eggs (Large)</option>
            <option value="Sliced Bread">Sliced Bread</option>
            <option value="White Rice">White Rice</option>
            <option value="Milk">Milk</option>
            <option value="Butter">Butter</option>
            <option value="Sugar">Sugar</option>
            <option value="Flour">Flour</option>
            <option value="Salt">Salt</option>
           
        </select>
        <label for="quantity">Quantity:</label>
        <input type="text" id="quantity" name="quantity" placeholder="Enter quantity...">
        <label for="best_before">Best Before:</label>
        <input type="date" id="best_before" name="best_before">
        <label for="sku">SKU Code:</label>
        <input type="text" id="sku" name="sku" placeholder="Enter SKU code...">
        <label for="date">Booking Date:</label>
        <input type="date" id="date" name="date">
        <label for="customer_name">Customer Name:</label>
        <input type="text" id="customer_name" name="customer_name" placeholder="Enter customer's name...">
        <label for="customer_email">Customer Email:</label>
        <input type="email" id="customer_email" name="customer_email" placeholder="Enter customer's email...">
        <label for="notes">Notes:</label>
        <textarea id="notes" name="notes" placeholder="Enter any additional notes..."></textarea>
        <input type="submit" value="Book">
    </form>
    <div class="footer">
        &copy; 2024 Rakusen. All rights reserved.
    </div>
</div>

</body>
</html>


<footer class="footer">
    <p>&copy; 2024 Rakusen. All rights reserved.</p>
</footer>
</body>
</html>
