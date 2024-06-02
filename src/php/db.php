<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fishing_forum";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error, 3, "/var/tmp/my-errors.log"); // Log error to file
    die("Connection failed: " . $conn->connect_error); // Display error message
} else {
    // echo "Connected successfully"; // Uncomment for debugging purposes
}
?>
