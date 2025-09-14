<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Change if your MySQL username is different
$password = "";    // Change if your MySQL password is set
$dbname = "document_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
?>
