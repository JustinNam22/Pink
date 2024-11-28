<?php
session_start();
require 'dbConnect.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$user = $_SESSION['user'];

// Fetch all posts from the database


$stmt = $pdo->query("SELECT posts.id, posts.title, posts.created_at, posts.updated_at, posts.user_id, users.name AS name 
                     FROM posts 
                     JOIN users ON posts.user_id = users.id 
                     ORDER BY posts.created_at DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chewsday | Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="h0me.css">
</head>
<body>
<div class="background">
  
<div class="home_container">
    <div class="welcome">
        <h1>Welcome to Chewsday, <?php echo htmlspecialchars($user['name']); ?>!</h1>
        <p><b>Username:</b> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><b>Email:</b> <?php echo htmlspecialchars($user['email']); ?></p>



        
        <a href="create_post.php" class="home-button">Create post</a>
        <a href="edit_profile.php" class="home-button">Edit profile</a>
        <a href="mailto:nguyenhongnamjt@gmail.com" class="home-button">Contact Admin</a>
        <a href="logout.php" class="home-button">Log Out</a>
        <div class="posts">
    <h3>All Posts</h3>
    <?php foreach ($posts as $post): ?>
        <div class="post" id="post-<?php echo $post['id']; ?>">
            <h3><a href="view_post.php?post_id=<?php echo $post['id']; ?>">
                <?php echo htmlspecialchars($post['title']); ?>
            </a></h3>
            <p>Posted by: <?php echo htmlspecialchars($post['name']); ?></p>
            <p>Posted on: <?php echo date("d/m/Y, H:i", strtotime($post['created_at'])); ?></p>
            <?php if (!empty($post['updated_at'])): ?>
                <p>Updated on: <?php echo date("d/m/Y, H:i", strtotime($post['updated_at'])); ?></p>
            <?php endif; ?>

            <!-- Check if the logged-in user is the creator of the post -->
            <?php if ($user['id'] === $post['user_id']): ?>
                <a href="edit_post.php?post_id=<?php echo $post['id']; ?>" class="home-button">Edit</a>
                <a href="delete_post.php?post_id=<?php echo $post['id']; ?>" class="home-button"
                   onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

</div>

    </div>
</div>

</body>
</html>
