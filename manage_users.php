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

    // Fetch all users
    $stmt = $pdo->query("SELECT id, name, email, created_at FROM users ORDER BY created_at DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chewsday | Manage User</title>
    <link rel="stylesheet" href="manage_userz.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">


</head>
<body>
    <div class="container">
        <h1>Manage Users</h1>
        <a href="add_user.php" class="button">Add New User</a>
        <ul>
            <?php foreach ($users as $user): ?>
                <li>
                    <h2><?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>)</h2>
                    <p><strong>Registered At:</strong> <?= htmlspecialchars($user['created_at']) ?></p>
                    <a href="edit_profile.php?user_id=<?= $user['id'] ?>" class="button">Edit</a>
                    <a href="delete_user.php?user_id=<?= $user['id'] ?>" class="button" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>

            <?php endforeach; ?>
        </ul>
        <a href="admin_home_page.php" class="back-home">Back to Dashboard</a>
    </div>
</body>
</html>
