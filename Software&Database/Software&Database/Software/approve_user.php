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

// Check if the approve button is clicked
if (isset($_POST['approve_user'])) {
    // Get the user ID from the form
    $user_id = $_POST['user_id'];

    // Update the approval status in the database to 'Approved'
    $update_query = "UPDATE users SET approval_status = 'Approved' WHERE user_id = $user_id";
    mysqli_query($connection, $update_query);

    // Redirect back to the page where users are listed for approval
    header("Location: Manage_users.php");
    exit();
}
?>