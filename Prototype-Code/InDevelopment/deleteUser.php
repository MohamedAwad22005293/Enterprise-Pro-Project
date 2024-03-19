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

// Check if user_id is set and not empty
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id']) && !empty($_POST['user_id'])) {
    // Sanitize user_id to prevent SQL injection
    $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);

    // Delete the user from the database
    $delete_query = "DELETE FROM users WHERE user_id = '$user_id'";
    if (mysqli_query($connection, $delete_query)) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . mysqli_error($connection);
    }
}
?>

