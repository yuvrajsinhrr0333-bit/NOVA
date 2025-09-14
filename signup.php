<?php
// Include database connection
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($username && $email && $password) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Prepare and execute insert
        $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $username, $hashedPassword, $email);
        if ($stmt->execute()) {
            echo "Signup successful. You can now log in.";
        } else {
            echo "Signup failed: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Invalid request.";
}
?>
