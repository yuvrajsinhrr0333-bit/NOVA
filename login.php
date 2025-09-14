<?php
// Include database connection
require_once 'db_connect.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($username && $password) {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $hashedPassword);
            $stmt->fetch();
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                echo "Login successful.";
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "User not found.";
        }
        $stmt->close();
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Invalid request.";
}
?>
