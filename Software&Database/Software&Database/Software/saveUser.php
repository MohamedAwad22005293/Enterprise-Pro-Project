<?php
session_start();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (!isset($_SESSION['user_email'])) {
        // Redirect to login page or show unauthorized access message
        header("Location: Login.html");
        exit();
    }

    // Check if user_id is provided in the POST data
    if (isset($_POST['user_id'])) {
        
        $user_id = $_POST['user_id'];

        // Establish a database connection
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "rwsdb";

        $connection = mysqli_connect($host, $username, $password, $database);

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        // Retrieve modified user details from the POST data
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $role = $_POST['role'];

        // Update user details in the database
        $query = "UPDATE users 
                  SET full_name='$full_name', email='$email', phone_number='$phone_number', role='$role' 
                  WHERE user_id='$user_id'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            header("Location: Manage_users.php");
            echo "User details updated successfully.";
        } else {
            echo "Error updating user details: " . mysqli_error($connection);
        }

        // Close the database connection
        mysqli_close($connection);
    } else {
        echo "User ID not provided.";
    }
} else {
    // Handle invalid request method
    echo "Invalid request method.";
}
?>