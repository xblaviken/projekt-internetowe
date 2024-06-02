<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'php/db.php';

// Fetch threads
$sql_threads = "SELECT threads.id, threads.title, threads.content, threads.category, threads.created_at, users.username 
                FROM threads 
                JOIN users ON threads.user_id = users.id 
                ORDER BY threads.created_at DESC";
$result_threads = $conn->query($sql_threads);

if (!$result_threads) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fishing Forum</title>
    <link rel="stylesheet" href="../public/css/styles.css">
    <script>
        function handleThreadClick(event, threadId) {
            <?php if (!isset($_SESSION['user_id'])): ?>
                event.preventDefault();
                document.getElementById('loginModal').style.display = 'block';
            <?php else: ?>
                window.location.href = `php/thread.php?thread_id=${threadId}`;
            <?php endif; ?>
        }

        function closeModal() {
            document.getElementById('loginModal').style.display = 'none';
        }
    </script>
</head>
<body>
    <header>
        <h1>Fishing Forum</h1>
        <nav>
            <ul>
                <li><a href="../src/index.php">Home</a></li>
                <li><a href="../public/create_thread.html">Create Thread</a></li>
                <li><a href="../public/login.html">Login</a></li>
                <li><a href="../public/register.html">Register</a></li>
            </ul>
            <form action="../src/php/search.php" method="get">
                <input type="text" name="query" placeholder="Search...">
                <button type="submit">Search</button>
            </form>
        </nav>
    </header>
    <main>
        <h2>Latest Threads</h2>
        <div id="threads">
            <?php
            if ($result_threads->num_rows > 0) {
                while($thread = $result_threads->fetch_assoc()) {
                    echo '<div class="thread">';
                    echo '<h3><a href="#" onclick="handleThreadClick(event, ' . $thread['id'] . ')">' . htmlspecialchars($thread['title']) . '</a></h3>';
                    echo '<p>' . htmlspecialchars($thread['content']) . '</p>';
                    echo '<p>Category: ' . htmlspecialchars($thread['category']) . '</p>';
                    echo '<p>Posted by: ' . htmlspecialchars($thread['username']) . ' on ' . $thread['created_at'] . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No threads found.</p>';
            }
            ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Fishing Forum</p>
    </footer>

    <!-- Login Modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p>You need to be logged in to view this thread.</p>
            <button onclick="window.location.href='../public/login.html'">Login</button>
        </div>
    </div>

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</body>
</html>

<?php
$conn->close();
?>
