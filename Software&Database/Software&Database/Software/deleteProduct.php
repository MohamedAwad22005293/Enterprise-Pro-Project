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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_product'])) {
    // Retrieve product code from the form
    $product_code = $_POST['product_code'];

    // Prepare and execute SQL query to delete the product from the database
    $query = "DELETE FROM products WHERE productCode = ?";
    $statement = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($statement, "s", $product_code);
    $result = mysqli_stmt_execute($statement);

    if ($result) {
        echo "Product deleted successfully.";
        header("Location: Inventory.php");
    } else {
        echo "Error: " . mysqli_error($connection);
    }

    // Close statement and connection
    mysqli_stmt_close($statement);
    mysqli_close($connection);
}
?>