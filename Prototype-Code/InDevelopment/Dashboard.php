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
    

    
    .alerts-box {
        text-align: center;
        width: calc(30% - 20px); 
        background-color: #c9c97b;
        padding: 20px;
        margin-right: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        float: left;
    }


    .orders-box {
        text-align: center;
        width: calc(30% - 20px); 
        background-color: #78ce78;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        display: inline-block; 
        float: right
    
    }
    .processing-box {
        text-align: center;
        width: calc(30% - 20px);
        background-color: #60eb60;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        display: inline-block; 
        float: left
    
    }
    
    .inventory-box {
        text-align: center;
        width: calc(30% - 20px); 
        background-color: #6f6fd5;
        padding: 20px;
        margin-right: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        float: left; 
    }
.inventory-box .search-bar {
    margin-bottom: 10px;
}

.inventory-box .search-bar input[type="text"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: calc(100% - 100px); 
}

.inventory-box .search-bar button {
    padding: 8px 15px;
    border: none;
    border-radius: 5px;
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
}

.inventory-box .search-bar button:hover {
    background-color: #45a049;
}
.stats-box {
    text-align: center;
    width: calc(30% - 20px); 
    background-color: #ffffff;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1); /
    display: inline-block; 
    float: right; 
}

.alerts-box,
.orders-box,
.processing-box,
.inventory-box,
.stats-box {
    width: calc(40% - 20px);
    height: 240px; 
    margin: 20px;
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
    

   
    @media (max-width: 600px) {
        .alerts-box {
            width: calc(100% - 20px); 
            margin-right: 0;
        }
        .orders-box {
            width: calc(100% - 20px);
        }
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
        <li><a href="Inventory.php">Items</a></li>
        <li><a href="Orders.php ">Orders</a></li>
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
        <h2>Dashboard</h2>
        <p>Home/Dashboard</p>
        <div class="alerts-box">
            <h3>Alerts</h3>
            <p>Display alerts here.</p>
        </div>
        <div class="stats-box">
            <h3>Statistics Analysis</h3>
            <p>.</p>
        </div>
        <div class="inventory-box">
            <h3>Current Supply</h3>
            <div class="search-bar">
                <input type="text" placeholder="Search...">
                <button type="button">Search</button>
            </div>
            <p>Display inventory here.</p>
        </div>
        <div class="orders-box">
            <h3>Orders Made</h3>
            <p></p>
        </div>
        <div class="processing-box">
            <h3>Orders Processing</h3>
            <p></p>
        </div>
    </div>
</div>
<footer class="footer">
    <p>&copy; 2024 Rakusen. All rights reserved.</p>
</footer>
</body>
</html>