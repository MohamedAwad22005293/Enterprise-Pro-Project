<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rakusen - Alerts</title>
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
        border-bottom: 1px solid #f5f6f7;
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
        background-color: #fff;
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
    
    .content button[type="button"] {
        background-color: #88cbfa;
        color: #0d0c0c;
        border: 3px solid #000;
        font-weight: bold;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .row {
        display: flex;
        justify-content: center;
    }

    .box {
        width: 200px;
        height: 100px;
        background-color: #88cbfa;
        border: 1px solid #000;
        margin: 5px;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .bold-text {
        font-weight: bold;
    }

    .search-bar {
        display: flex;
        align-items: center;
        margin-top: -40px;
        margin-left: 830px;
    }

    .search-bar input[type="text"] {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 150px;
    }

    .search-bar button {
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
        margin-left: 10px;
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


</style>
</head>
<body>

<div class="top-bar">
    <div class="top-left">
        <img src="Images\rakusen.png" alt="Company Logo" class="logo">
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
        <li><a href="Dashboard.html">Dashboard</a></li>
        <li><a href="Orders.html">Orders</a></li>
        <li><a href="Reports.html">Reports</a></li>
        <li><a href="Account.html">Account</a></li>
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
