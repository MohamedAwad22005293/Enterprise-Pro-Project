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
<title>Rakusen - Inventory</title>
<link rel="stylesheet" href="InventoryStyle.Css">
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
        <h2>Inventory</h2>

        <div class="search-bar">
            <input type="text" id="nameSearch" placeholder="Search by name">
            <input type="text" id="codeSearch" placeholder="Search by product code/ID">
        </div>
        
        <button class="add-btn" onclick="showAddForm()">Add New</button>
        <div class="item-box">
            <div class="item-actions">
                <h3>Item 1</h3>
                <div>
                    <button class="edit-btn">Edit</button>
                    <button class="delete-btn">Delete</button>
                </div>
            </div>
            <p>Product Code/ID: 123456</p>
            <p>Description: Description of Item 1</p>
            <img src="path_to_image.jpg" alt="Item 1 Image">
            <p>Price: $19.99</p>
            <p>Status: In stock</p>
            <p>Quantity: 50</p>
            <p>Before Before: 2024-06-13</p>
        </div>

        <div class="item-box">
            <div class="item-actions">
                <h3>Item 2</h3>
                <div>
                    <button class="edit-btn">Edit</button>
                    <button class="delete-btn">Delete</button>
                </div>
            </div>
            <p>Product Code/ID: 789012</p>
            <p>Description: Description of Item 2</p>
            <img src="path_to_image.jpg" alt="Item 2 Image">
            <p>Price: $24.99</p>
            <p>Status: Out of stock</p>
            <p>Quantity: 0</p>
            <p>Before Before: 2024-012-18</p>
            <div id="addForm" style="display: none;">
                <h2>Add New Item</h2>
                <form id="addItemForm"><!-- Placeholder form. Will be changed </p> -->
                    <label for="itemName">Item Name:</label>
                    <input type="text" id="itemName" name="itemName" required><br><br>
            
                    <label for="itemCode">Product Code/ID:</label>
                    <input type="text" id="itemCode" name="itemCode" required><br><br>
            
                    <label for="itemDescription">Description:</label><br>
                    <textarea id="itemDescription" name="itemDescription" rows="4" cols="50" required></textarea><br><br>
            
                    <label for="itemImage">Image:</label>
                    <input type="file" id="itemImage" name="itemImage"><br><br>
            
                    <label for="itemPrice">Price:</label>
                    <input type="number" id="itemPrice" name="itemPrice" required><br><br>
            
                    <label for="itemStatus">Status:</label>
                    <select id="itemStatus" name="itemStatus">
                        <option value="In stock">In stock</option>
                        <option value="Out of stock">Out of stock</option>
                    </select><br><br>
            
                    <label for="itemQuantity">Quantity:</label>
                    <input type="number" id="itemQuantity" name="itemQuantity" required><br><br>
            
                    <button type="button" onclick="addItem()">Add Item</button>
                </form>
        </div>
    </div>
</div>

<footer class="footer">
    <p>&copy; 2024 Rakusen. All rights reserved.</p>
</footer>

</body>
</html>

