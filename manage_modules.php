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

    // Fetch all modules
    $stmt = $pdo->query("SELECT id, name FROM modules");
    $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chewsday | Manage Modules</title>
    <link rel="stylesheet" href="manage_m0dules.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">

</head>
<body>
    <div class="container">
        <h1>Manage Modules</h1>
        <a href="add_module.php" class="button">Add New Module</a>
        <ul>
            <?php foreach ($modules as $module): ?>
                <li>
                    <h2><?= htmlspecialchars($module['name']) ?></h2>
                    <a href="edit_module.php?module_id=<?= $module['id'] ?>" class="button">Edit</a>
                    <a href="delete_module.php?module_id=<?= $module['id'] ?>" class="button"
                       onclick="return confirm('Are you sure you want to delete this module?');">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="admin_home_page.php" class="back-home">Back to admin dashboard</a>
    </div>
</body>
</html>
