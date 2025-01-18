<?php
// Database configuration
$host = 'localhost';   
$username = 'root';     // Your MySQL username (default is root)
$password = '';         // Your MySQL password (default is empty for XAMPP)
$dbname = 'signup';     // Your database name (make sure it matches the name of the database)

$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // Optional: Uncomment to check if connection is successful
    // echo "Connection successful"; 
}
?>
