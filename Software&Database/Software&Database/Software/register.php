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
$name = $_POST['fullName'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Verify password confirmation
if ($password !== $confirm_password) {
    echo "Error: Passwords do not match";
    exit();
}

// Check if the email already exists in the database
$email_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
$result = mysqli_query($connection, $email_check_query);
$user = mysqli_fetch_assoc($result);

if ($user) { // If user exists
    echo "Error: Email already exists";
    header("Location: Register.html");
    exit();
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Default role for new users
$role = 'Employee';
// Default approval status for new users
$approval_status = 'Pending';

// Insert the data into the 'users' table
$query = "INSERT INTO users(full_name, email, password, role, approval_status) 
          VALUES ('$name', '$email', '$hashed_password', '$role', '$approval_status')";

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