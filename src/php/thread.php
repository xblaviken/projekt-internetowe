<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "You need to be logged in to view this thread."]);
    exit;
}

if (!isset($_GET['thread_id'])) {
    die("Thread ID not specified.");
}

$thread_id = $_GET['thread_id'];

// Fetch thread details
$sql_thread = "SELECT threads.id, threads.title, threads.content, threads.category, threads.created_at, users.username 
               FROM threads 
               JOIN users ON threads.user_id = users.id 
               WHERE threads.id = ?";
$stmt_thread = $conn->prepare($sql_thread);
$stmt_thread->bind_param('i', $thread_id);
$stmt_thread->execute();
$result_thread = $stmt_thread->get_result();

if ($result_thread->num_rows === 0) {
    die("Thread not found.");
}

$thread = $result_thread->fetch_assoc();

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thread: <?= htmlspecialchars($thread['title']) ?></title>
    <link rel="stylesheet" href="../../public/css/styles.css">
    <script>
        function submitReply(event) {
            event.preventDefault();
            const formData = new FormData(event.target);

            fetch('reply.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Refresh the replies section
                    fetchReplies();
                    form.reset();  // Clear the textarea after submitting
                } else {
                    alert(data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function fetchReplies() {
            const threadId = <?= json_encode($thread['id']) ?>;
            fetch(`../../src/php/fetch_replies.php?thread_id=${threadId}`)
            .then(response => response.json())
            .then(data => {
                const repliesDiv = document.getElementById('replies');
                repliesDiv.innerHTML = ''; // Clear existing replies

                data.replies.forEach(reply => {
                    const replyDiv = document.createElement('div');
                    replyDiv.classList.add('reply');
                    replyDiv.innerHTML = `
                        <p>${reply.username} on ${reply.created_at}</p>
                        <p>${reply.content}</p>
                    `;
                    repliesDiv.appendChild(replyDiv);
                });
            })
            .catch(error => console.error('Error:', error));
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchReplies(); // Initial load of replies
        });
    </script>
</head>
<body>
    <header>
        <h1>Fishing Forum</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../../public/create_thread.html">Create Thread</a></li>
                <li><a href="../../public/login.html">Login</a></li>
                <li><a href="../../public/register.html">Register</a></li>
            </ul>
            <form action="search.php" method="get">
                <input type="text" name="query" placeholder="Search...">
                <button type="submit">Search</button>
            </form>
        </nav>
    </header>
    <main>
        <div class="thread">
            <h2><?= htmlspecialchars($thread['title']) ?></h2>
            <p><?= htmlspecialchars($thread['content']) ?></p>
            <p>Category: <?= htmlspecialchars($thread['category']) ?></p>
            <p>Posted by: <?= htmlspecialchars($thread['username']) ?> on <?= $thread['created_at'] ?></p>
        </div>

        <h3>Replies</h3>
        <div id="replies">
            <?php
            if ($result_replies->num_rows > 0) {
                while($reply = $result_replies->fetch_assoc()) {
                    echo '<div class="reply">';
                    echo '<p>' . htmlspecialchars($reply['username']) . ' on ' . $reply['created_at'] . '</p>';
                    echo '<p>' . htmlspecialchars($reply['content']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No replies found.</p>';
            }
            ?>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
            <h3>Reply to this thread</h3>
            <form id="replyForm" onsubmit="submitReply(event)">
                <input type="hidden" name="thread_id" value="<?= $thread['id'] ?>">
                <textarea name="content" rows="5" cols="50" required></textarea>
                <button type="submit">Submit Reply</button>
            </form>
        <?php else: ?>
            <p>You need to be logged in to reply.</p>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Fishing Forum</p>
    </footer>
</body>
</html>

<?php
$stmt_thread->close();
$stmt_replies->close();
$conn->close();
?>
