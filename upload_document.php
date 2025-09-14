<?php
// Include database connection
require_once 'db_connect.php';

// Check if form is submitted and file is uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 1; // Default user_id=1 for demo
    $title = isset($_POST['title']) ? $conn->real_escape_string($_POST['title']) : '';
    $description = isset($_POST['description']) ? $conn->real_escape_string($_POST['description']) : '';
    $file = $_FILES['document'];

    // File upload settings
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $fileName = basename($file['name']);
    $targetFile = $uploadDir . uniqid() . '_' . $fileName;

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // Insert file info into database
        $stmt = $conn->prepare("INSERT INTO documents (user_id, title, description, file_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('isss', $user_id, $title, $description, $targetFile);
        if ($stmt->execute()) {
            echo "File uploaded and data saved successfully.";
        } else {
            echo "Database error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "File upload failed.";
    }
} else {
    echo "No file uploaded.";
}
?>
