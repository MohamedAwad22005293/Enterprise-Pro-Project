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

// Fetch user data from the database based on the user email stored in the session
$user_email = $_SESSION['user_email'];
$query = "SELECT full_name, email, password, phone_number FROM users WHERE email = '$user_email'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    // User data found, assign it to $user_data
    $user_data = mysqli_fetch_assoc($result);
} else {
   
    // User data not found or error occurred, handle accordingly
   
    echo "Error: User data not found";
    exit();
}

// Close the database connection
mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rakusen - Account</title>
<style>
 body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f2f2;
        padding-bottom: 50px;
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
    

    
    .name-box {
        text-align: center;
        width: calc(30% - 20px); 
        background-color: #ffffff;
        padding: 20px;
        margin-right: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        float: left;
    }


    .email-box {
        text-align: center;
        width: calc(30% - 20px); 
        background-color: #ffffff;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        display: inline-block; 
        float: right
    
    }
    .password-box {
        text-align: center;
        width: calc(30% - 20px);
        background-color: #ffffff;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        display: inline-block; 
        float: left
    
    }
    
    .contact-box {
        text-align: center;
        width: calc(30% - 20px); 
        background-color: #ffffff;
        padding: 20px;
        margin-right: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        float: right; 
    }


.name-box,
.email-box,
.password-box,
.contact-box{
    width: calc(40% - 20px);
    height: 240px; 
    margin: 20px;
}
    

    .edit-save-buttons {
        display: flex;
        justify-content: center; /* Center the buttons */
        justify-content:  ;
        margin-top: 10px;
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
        .field-box {
            width: calc(100% - 40px);
            margin-right: 0;
        }
    }

    .footer {
        background-color: #333;
        color: #fff;
        text-align: center;
        padding: 0px;
        position: fixed;
        bottom: 0;
        width: 100%;
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
        <li><a href="Inventory.php">Items</a></li>
        <li><a href="Orders.php">Orders</a></li>
        <li><a href="Alerts.php">Alerts</a></li>
        <li><a href="Reports.php">Reports</a></li>
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
        <h2>Profile</h2>
        <p>Welcome, <?php echo $user_data['full_name']; ?>!</p>
        <div class="name-box">
            <h3>Name</h3>
            <form action="update_profile.php" method="post">
                <input type="text" name="full_name" value="<?php echo $user_data['full_name']; ?>">
                <div class="edit-save-buttons">
                    <button type="submit" name="save_name">Save</button>
                </div>
            </form>
        </div>
        <div class="email-box">
            <h3>Email</h3>
            <p><?php echo $user_data['email']; ?></p>
            <form action="update_profile.php" method="post">
                <input type="email" name="email" value="<?php echo $user_data['email']; ?>">
                <div class="edit-save-buttons">
                    <button type="submit" name="save_email">Save</button>
                </div>
            </form>
        </div>
        <div class="password-box">
            <h3>Password</h3>
            <p>[Password hidden]</p>
            <form action="update_profile.php" method="post">
                <input type="password" name="password" placeholder="Enter new password">
                <div class="edit-save-buttons">
                    <button type="submit" name="save_password">Save</button>
                </div>
            </form>
        </div>
        <div class="contact-box">
            <h3>Contact Number</h3>
            <p><?php echo $user_data['phone_number']; ?></p>
            <form action="update_profile.php" method="post">
                <input type="tel" name="contact_number" value="<?php echo $user_data['phone_number']; ?>">
                <div class="edit-save-buttons">
                    <button type="submit" name="save_contact_number">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<footer class="footer">
    <p>&copy; 2024 Rakusen. All rights reserved.</p>
</footer>

</body>
</html>