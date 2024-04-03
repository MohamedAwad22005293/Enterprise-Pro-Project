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
    <div class="middle-section">
        <h1>Rakusen Warehouse</h1>
    </div>
    <div class="top-right">
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
                                        <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
                                        <button type='submit'>Save</button>
                                        <button onclick='confirmDelete(" . $row['user_id'] . ")'>Delete</button>
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
        <li><a href="Dashboard.php">Dashboard</a></li>
        <li><a href="Inventory.php">Inventory</a></li>
        <li><a href="Alerts.php">Alerts</a></li>
        <li><a href="Orders.php">Orders</a></li>
        <li><a href="Reports.php">Reports</a></li>
        <li><a href="AccountPage.php">Account</a></li>
        <li><a href="Logout.php">Logout</a></li>
    </ul>
</div>


<footer class="footer">
    <p>&copy; 2024 Rakusen. All rights reserved.</p>
</footer>

<script>
    function confirmDelete(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            // If user confirms, initiate AJAX request to delete user
            var x = new XMLHttpRequest();
            x.open("POST", "deleteUser.php", true);
            x.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            x.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Reload the page after successful deletion
                    location.reload();
                }
            };
            xhr.send("user_id=" + userId);
        }
    }
</script>
</body>
</html>