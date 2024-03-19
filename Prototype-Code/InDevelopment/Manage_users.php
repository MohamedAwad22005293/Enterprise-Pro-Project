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
<style>
   body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f2f2;
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
        border-radius: 5px;
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

   
    .user-box {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        margin-top: 50px;
        overflow: hidden;
    }

    .user-box table {
        width: 100%;
        border-collapse: collapse;
    }

    .user-box table th,
    .user-box table td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .user-box table th {
        background-color: #f2f2f2;
    }

    .user-box table td.actions {
        text-align: center;
    }

    .user-box table td.actions button {
        padding: 5px 10px;
        margin-right: 5px;
        border: none;
        background-color: #007bff;
        color: #fff;
        border-radius: 3px;
        cursor: pointer;
    }

    .user-box table td.actions button:hover {
        background-color: #0056b3;
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
        <li><a href="Inventory.php">Items</a></li>
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