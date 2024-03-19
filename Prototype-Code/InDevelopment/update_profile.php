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

// Check which form was submitted and process the update accordingly
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle name update
    if (isset($_POST['save_name'])) {
        $full_name = $_POST['full_name'];
        $user_email = $_SESSION['user_email'];

        $update_query = "UPDATE users SET full_name = '$full_name' WHERE email = '$user_email'";
        mysqli_query($connection, $update_query);
    }
    // Handle email update
    elseif (isset($_POST['save_email'])) {
        $email = $_POST['email'];
        $user_email = $_SESSION['user_email'];

        $update_query = "UPDATE users SET email = '$email' WHERE email = '$user_email'";
        mysqli_query($connection, $update_query);
        // Update the session variable with the new email
        $_SESSION['user_email'] = $email;
    }
    // Handle password update (ensure to hash the password before storing it in the database)
    elseif (isset($_POST['save_password'])) {
        $password = $_POST['password'];
        $user_email = $_SESSION['user_email'];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE users SET password = '$hashed_password' WHERE email = '$user_email'";
        mysqli_query($connection, $update_query);
    }
    // Handle contact number update
    elseif (isset($_POST['save_contact_number'])) {
        $contact_number = $_POST['contact_number'];
        $user_email = $_SESSION['user_email'];

        $update_query = "UPDATE users SET phone_number = '$contact_number' WHERE email = '$user_email'";
        mysqli_query($connection, $update_query);
    }

    // Redirect back to the profile page
    header("Location: AccountPage.php");
    exit();
}

// Close the database connection
mysqli_close($connection);
?>