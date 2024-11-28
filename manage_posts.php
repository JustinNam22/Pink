<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

try {
    // Connect to the database using PDO
    $dsn = "mysql:host=localhost;dbname=hn;charset=utf8mb4";
    $username = "root";
    $password = "";

    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all posts with user and module details
    $stmt = $pdo->query("SELECT posts.id, posts.title, posts.content, posts.created_at, users.name AS user_name, modules.name AS module_name
                         FROM posts
                         LEFT JOIN users ON posts.user_id = users.id
                         LEFT JOIN modules ON posts.module_id = modules.id
                         ORDER BY posts.created_at DESC");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chewsday | Post Management</title>
    <link rel="stylesheet" href="manage_p0sts.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">


    <script>
        function deletePost(postId) {
            if (confirm("Are you sure you want to delete this post?")) {
                fetch(`delete_post.php?post_id=${postId}`, {
                    method: 'GET',
                })
                .then(response => response.text())
                .then(message => {
                    alert(message); // Alert the response message
                    if (message === "Post deleted successfully.") {
                        document.getElementById(`post-${postId}`).remove(); // Remove the post from DOM
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred. Please try again.");
                });
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Post Management</h1>
        <a href="add_post.php" class="button">Add New Post</a>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li id="post-<?= $post['id'] ?>">
                    <h2><?= htmlspecialchars($post['title']) ?></h2>
                    <p><strong>Author:</strong> <?= htmlspecialchars($post['user_name']) ?></p>
                    <p><strong>Module:</strong> <?= htmlspecialchars($post['module_name']) ?></p>
                    <p><strong>Created At:</strong> <?= htmlspecialchars($post['created_at']) ?></p>
                    <p><strong>Content:</strong><br><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                    <a href="edit_post.php?post_id=<?= $post['id'] ?>" class="button">Edit</a>
                    <a href="javascript:void(0);" class="button" onclick="deletePost(<?= $post['id'] ?>)">Delete</a>

<script>
    function deletePost(postId) {
        if (confirm("Are you sure you want to delete this post?")) {
            fetch(`delete_post.php?post_id=${postId}`, {
                method: 'GET',  // Use GET to keep the URL structure intact
            })
            .then(response => response.text()) // Get plain text response from PHP
            .then(message => {
                alert(message); // Show the response message
                if (message === "Post deleted successfully.") {
                    document.getElementById(`post-${postId}`).remove(); // Remove the post element from DOM
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An error occurred. Please try again.");
            });
        }
    }
</script>


                </li>
            <?php endforeach; ?>
        </ul>
        <a href="admin_home_page.php" class="back-home">Back to Admin Home Page</a>
    </div>
</body>
</html>
