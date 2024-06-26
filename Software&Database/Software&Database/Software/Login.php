<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$username = "root";
$password = "";
$database = "rwsdb";

// Create connection
$connection = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if user exists with the provided email
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) == 1) {
        // User exists, fetch user data
        $user = mysqli_fetch_assoc($result);

        // Check if user's approval status is 'Approved'
        if ($user['approval_status'] == 'Approved') {
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Password is correct, store user data in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];

                // Redirect to personal account page
                header("Location: Dashboard.php");
                exit();
            } else {
                // Password is incorrect, display error message
                echo "Error: Incorrect password";
                header("Location: Login.html");
                exit();
            }
        } else {
            // User's approval status is not 'Approved', display error message
            echo "Error: Your account is not approved yet.";
            header("Location: Login.html");
            exit();
        }
    } else {
        // User does not exist, display error message
        echo "Error: User not found";
        header("Location: Login.html");
        exit();
    }
}

// Close the database connection
mysqli_close($connection);
?>