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

// Check if the form for deleting a user is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    // Process the deletion of the user
    $user_id = $_POST['user_id'];

    // Delete the user from the database
    $delete_query = "DELETE FROM users WHERE user_id = '$user_id'";
    if (mysqli_query($connection, $delete_query)) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rakusen - Manage Users</title>
<link rel="stylesheet" href="Manage_usersStyle.Css">
</head>
<body>

<div class="top-bar">
    <div class="top-left">
        <img src="rakusen.png" alt="Company Logo" class="logo">
    </div>
    <div class="middle-section" style="padding-left: 255px;">
        <h1>Rakusen Warehouse</h1>
    </div>
    <div class="top-right">
        <a href="Basketpage.html" style="color: rgb(0, 0, 0); margin-right: 15px;">Basket</a>
        <a href="ContactUsPage.html" style="color: rgb(0, 0, 0);">Contact Us</a>
    </div>
</div>
<div class="dashboard">
    <div class="content">
        <h2>Manage Users</h2>
        <?php

        // Check if the user is logged in and has manager role
        if (!isset($_SESSION['user_email'])) {
            // Redirect to login page or show unauthorized access message
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

        // Fetch all user details from the database
        $query = "SELECT * FROM users";
        $result = mysqli_query($connection, $query);

        // Check if any users are found
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='user-box'>
                        <form action='saveUser.php' method='POST'>
                            <table>
                                <tr>
                                    <th>User ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                                <tr>
                                    <td>" . $row['user_id'] . "</td>
                                    <td><input type='text' name='full_name' value='" . $row['full_name'] . "'></td>
                                    <td><input type='text' name='email' value='" . $row['email'] . "'></td>
                                    <td><input type='text' name='phone_number' value='" . $row['phone_number'] . "'></td>
                                    <td><input type='text' name='role' value='" . $row['role'] . "'></td>
                                    <td class='actions'>
    <form action='saveUser.php' method='POST'> <!-- Form for saving user -->
        <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
        <button type='submit'>Save</button>
    </form>
    <form action='deleteUser.php' method='POST'> <!-- Form for deleting user -->
        <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
        <button type='submit' name='delete_user'>Delete</button>
    </form>
</td>
                                </tr>
                            </table>
                        </form>
                      </div>";
            }
        } else {
            echo "No users found.";
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


<footer class="footer">
    <p>&copy; 2024 Rakusen. All rights reserved.</p>
</footer>
</body>
</html>