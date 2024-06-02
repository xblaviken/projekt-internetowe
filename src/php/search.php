<?php
require 'db.php';

if (isset($_GET['query'])) {
    $query = '%' . $_GET['query'] . '%';

    $sql = "SELECT threads.id, threads.title, threads.content, threads.category, threads.created_at, users.username 
            FROM threads 
            JOIN users ON threads.user_id = users.id 
            WHERE threads.title LIKE ? OR threads.content LIKE ?
            ORDER BY threads.created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Fishing Forum</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <header>
        <h1>Search Results</h1>
        <nav>
            <ul>
                <li><a href="../../public/index.html">Home</a></li>
                <li><a href="../../public/create_thread.html">Create Thread</a></li>
                <li><a href="../../public/login.html">Login</a></li>
                <li><a href="../../public/register.html">Register</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Search Results for "<?php echo htmlspecialchars($_GET['query']); ?>"</h2>
        <div id="threads">
            <?php if ($result->num_rows > 0): ?>
                <?php while($thread = $result->fetch_assoc()): ?>
                    <div class="thread">
                        <h3><?php echo htmlspecialchars($thread['title']); ?></h3>
                        <p><?php echo htmlspecialchars($thread['content']); ?></p>
                        <p>Category: <?php echo htmlspecialchars($thread['category']); ?></p>
                        <p>Posted by: <?php echo htmlspecialchars($thread['username']); ?> on <?php echo $thread['created_at']; ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No results found.</p>
            <?php endif; ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Fishing Forum</p>
    </footer>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
