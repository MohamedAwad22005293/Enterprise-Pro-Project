<?php
session_start();

$host = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "rwsdb"; 

// Create connection
$connection = mysqli_connect($host, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (isset($_SESSION['user_email'])) {
    // Close the database connection before redirection
    $connection->close();
    
    // Redirect to Account.html
    header("Location: AccountPage.php");
    exit();
} else {
    // Close the database connection before redirection
    $connection->close();
    
    // Redirect to Login.html
    header("Location: Login.html");
    exit();
}
?>
