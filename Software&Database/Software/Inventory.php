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

// Retrieve form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemName = $_POST['itemName'];
    $itemCode = $_POST['itemCode'];
    $itemDescription = $_POST['itemDescription'];
    $itemPrice = $_POST['itemPrice'];
    $itemStatus = $_POST['itemStatus'];
    $itemQuantity = $_POST['itemQuantity'];
    $itemBestBefore = $_POST['itemBestBefore'];

    // SQL query to insert data into the database
    $sql = "INSERT INTO products (productName, productCode, productDescription, price, productQuantity, bestBeforeDate, orderStatus)
            VALUES ('$itemName', '$itemCode', '$itemDescription', '$itemPrice', '$itemQuantity', '$itemBestBefore', '$itemStatus')";

    if ($connection->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}

$connection->close();
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
        <li><a href="AccountPage.php">Account</a></li>
        <?php 
            // Check if the user is logged in and retrieve their role from the database
            if (isset($_SESSION['user_email'])) {
                // Establish database connection
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
                if ($user_role == 'Manager') {
                    echo '<li><a href="VendorItems.php">Vendor Orders</a></li>';
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
            <?php
            // Establish connection
            $connection = mysqli_connect($host, $username, $password, $database);
            // Check connection
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }

            // Fetch products from the database
            $sql = "SELECT * FROM products";
            $result = mysqli_query($connection, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='item-actions'>";
                    echo "<h3>" .$row ['productName'] . "</h3>";
                    echo "<div>";
                    echo "<button class='edit-btn'>Edit</button>";
                    echo "<button class='delete-btn'>Delete</button>";
                    echo "</div>";
                    echo "</div>";
                    echo "<p>Product Code/ID: " . $row['productCode'] . "</p>";
                    echo "<p>Description: " . $row['productDescription'] . "</p>";
                    echo "<p>Price: " . $row['price'] . "</p>";
                    echo "<p>Status: " . $row['orderStatus'] . "</p>";
                    echo "<p>Quantity: " . $row['productQuantity'] . "</p>";
                    echo "<p>Best Before: " . $row['bestBeforeDate'] . "</p>";
                }
            } else {
                echo "0 results";
            }
            mysqli_close($connection);
            ?>
        </div>
    </div>
</div>

<div id="addForm" style="display: none;">
    <h2>Add New Item</h2>
    <form id="addItemForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="itemName">Item Name:</label>
        <input type="text" id="itemName" name="itemName" required><br><br>
    
        <label for="itemCode">Product Code/ID:</label>
        <input type="text" id="itemCode" name="itemCode" required><br><br>
    
        <label for="itemDescription">Description:</label>
        <textarea id="itemDescription" name="itemDescription" required></textarea><br><br>
    
        <label for="itemPrice">Price:</label>
        <input type="text" id="itemPrice" name="itemPrice" required><br><br>
    
        <label for="itemStatus">Status:</label>
        <select id="itemStatus" name="itemStatus" required>
            <option value="In Stock">In Stock</option>
            <option value="Out of Stock">Out of Stock</option>
        </select><br><br>
    
        <label for="itemQuantity">Quantity:</label>
        <input type="number" id="itemQuantity" name="itemQuantity" required><br><br>
    
        <label for="itemBestBefore">Best Before:</label>
        <input type="date" id="itemBestBefore" name="itemBestBefore" required><br><br>
    
        <button type="submit" name="addItemBtn">Add Item</button>
    </form>
</div>

<script>
    function showAddForm() {
        var addForm = document.getElementById("addForm");
        if (addForm.style.display === "none") {
            addForm.style.display = "block";
        } else {
            addForm.style.display = "none";
        }
    }
</script>

</body>
                <footer class="footer">
                <p>&copy; 2024 Rakusen. All rights reserved.</p>
                </footer>


</html>

<?php
