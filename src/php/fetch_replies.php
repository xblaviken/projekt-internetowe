<?php
require 'db.php';

if (!isset($_GET['thread_id'])) {
    echo json_encode(["error" => "Thread ID not specified."]);
    exit;
}

$thread_id = $_GET['thread_id'];

// Fetch replies
$sql_replies = "SELECT posts.content, posts.created_at, users.username 
                FROM posts 
                JOIN users ON posts.user_id = users.id 
                WHERE posts.thread_id = ? 
                ORDER BY posts.created_at ASC";
$stmt_replies = $conn->prepare($sql_replies);
$stmt_replies->bind_param('i', $thread_id);
$stmt_replies->execute();
$result_replies = $stmt_replies->get_result();

$replies = [];
while ($reply = $result_replies->fetch_assoc()) {
    $replies[] = $reply;
}

$stmt_replies->close();
$conn->close();

echo json_encode(["replies" => $replies]);
?>
