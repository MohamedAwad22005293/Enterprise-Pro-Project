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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve product data from the form
    $product_name = $_POST['product_name'];
    $product_code = $_POST['product_code'];
    $product_description = $_POST['product_description'];
    $product_quantity = $_POST['product_quantity'];
    $price = $_POST['price'];
    $best_before_date = $_POST['best_before_date'];
    $order_status = $_POST['order_status'];

    // Check if the product already exists in the database
    $query = "SELECT * FROM products WHERE productCode = ?";
    $statement = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($statement, "s", $product_code);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

    if (mysqli_num_rows($result) > 0) {
        // Product exists, perform an update operation
        $query = "UPDATE products SET productName=?, productDescription=?, productQuantity=?, price=?, bestBeforeDate=?, orderStatus=? WHERE productCode=?";
        $statement = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($statement, "ssddsss", $product_name, $product_description, $product_quantity, $price, $best_before_date, $order_status, $product_code);
        $result = mysqli_stmt_execute($statement);

        if ($result) {
            echo "Product updated successfully.";
            header("Location: Inventory.php");
        } else {
            echo "Error updating product: " . mysqli_error($connection);
        }
    } else {
        // Product doesn't exist, display an error message
        echo "Product with code $product_code does not exist.";
    }

    // Close statement and connection
    mysqli_stmt_close($statement);
    mysqli_close($connection);
}
?>
