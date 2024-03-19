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
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f2f2;
    }

    .navbar {
        position: fixed;
        top: 103px;
        left: 0;
        width: 200px;
        height: calc(100% - 70px);
        background-color: #ffffff;
        color: #000000;
        padding-top: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
    }

    .navbar ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .navbar ul li {
        padding: 10px 20px;
        border-bottom: 1px solid #fff;
    }

    .navbar ul li:last-child {
        border-bottom: none;
    }
    
    .navbar ul li a {
    text-decoration: none; 
    color: black; 
}

.navbar ul li a:hover {
    color: #666; 
}
    .dashboard {
        margin-left: 200px;
        padding-top: 70px;
    }

    .content {
        text-align: center;
        background-color: #f4f2f2;
        padding: 20px;
        border-radius: 5px;

    }

    .top-bar {
        background-color: #ffffff;
        color: #000000;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        border-bottom: 1px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .logo {
        max-width: 50px;
        max-height: 50px;
    }

    .top-left {
        padding: 10px;
    }

    .top-right {
        padding: 30px;
        border-radius: 5px
    }


    @media (max-width: 600px) {
        .top-bar {
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }
        .top-right {
            margin-top: 10px; 
        }
        .navbar {
            top: 120px; 
        }
    }
    table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 5px;
        overflow: hidden;
        margin-top: 20px;
    }

    th, td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    img {
        max-width: 100px;
    }
    .item-box {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        margin-top: 50px;
        overflow: hidden;
    }

    .item-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .edit-btn, .delete-btn {
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .edit-btn {
        background-color: #4caf50; 
        color: white;
    }

    .delete-btn {
        background-color: #f44336; 
        color: white;
    }

    .edit-btn:hover, .delete-btn:hover {
        background-color: #333; 
    }
    .footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 0px ;
    position: fixed;
    bottom: 0;
    width: 100%;
    height: 5;
}
.footer:hover {
    display: none;
}
    </style>
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
        <a href="#" style="color: rgb(0, 0, 0);">Contact Us</a>
    </div>
</div>

<div class="navbar">
    <ul>
        <li><a href="Dashboard.php">Dashboard</a></li>
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

