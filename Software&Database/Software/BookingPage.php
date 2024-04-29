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
            <?php
            // Database credentials
            $servername = "localhost"; // or "127.0.0.1"
            $username = "your_username"; // Your MySQL username
            $password = "your_password"; // Your MySQL password
            $database = "rwsdb"; // Name of the database you want to connect to

            // Create connection
            $conn = new mysqli($servername, $username, $password, $database);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to select products
            $sql = "SELECT productName FROM products";
            $result = $conn->query($sql);

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['productName'] . "'>" . $row['productName'] . "</option>";
            }

            // Close connection
            $conn->close();
            ?>
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
        &copy; <?php echo date("Y"); ?> Rakusen. All rights reserved.
    </div>
</div>

</body>
</html>