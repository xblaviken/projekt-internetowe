<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "You need to be logged in to create a thread.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO threads (user_id, title, content, category) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isss', $user_id, $title, $content, $category);

    if ($stmt->execute()) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
