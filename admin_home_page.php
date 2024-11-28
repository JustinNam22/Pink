<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chewsday | Admin Home Page</title>
    <link rel="stylesheet" href="admin_h0me_page.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
</head>
<body>

<div class="form-container">
    <div class="admin_dashboard">
        <h1>Admin Home Page</h1>
        <h2>Users Management</h2>
        <ul>
            <li><a href="manage_posts.php">Manage Posts</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_modules.php">Manage Modules</a></li>
        </ul>
        <a href="logout.php" class="home-button">Log Out</a>
    </div>

</div>
</body>
</html>
