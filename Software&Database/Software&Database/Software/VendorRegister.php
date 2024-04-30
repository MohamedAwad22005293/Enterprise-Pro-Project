<?php

$host = "localhost"; 
$username = "root"; 
$password = "";
$database = "rwsdb"; 

// Create connection
$connection = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$connection) {
    // If connection fails, print an error message and terminate the script
    die("Connection failed: " . mysqli_connect_error());
} else {
    // If connection succeeds, print a success message
    echo "Connected successfully";
}

// Retrieve form data
$vendor_id = $_POST['company_id'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Verify password confirmation
if ($password !== $confirm_password) {
    echo "Error: Passwords do not match";
    exit();
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Default role for new users
$role = 'Vendor';

// Insert the data into the 'users' table
$query = "INSERT INTO users(vendor_id, email, password, role) 
          VALUES ('$vendor_id', '$email', '$hashed_password', '$role')";

// Execute the query
$result = mysqli_query($connection, $query);

// Check if the query was successful
if (!$result) {
    // If query fails, print an error message
    echo "Error: " . mysqli_error($connection);
} else {
    // If query succeeds, redirect the user to the login page
    header("Location: Login.html");
    exit();
}

// Close the database connection
mysqli_close($connection);
?>