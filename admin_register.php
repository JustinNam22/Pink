<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $admin_key = $_POST['admin_key'];

    // Validate input
    $errors = [];
    if (empty($username)) {
        $errors['username'] = 'Username is required';
    }
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }
    if ($admin_key !== '123') {
        $errors['admin_key'] = 'Invalid admin key';
    }

    if (empty($errors)) {
        try {
            // Connect to the database
            $pdo = new PDO('mysql:host=localhost;dbname=hn', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert admin data into the database
            $stmt = $pdo->prepare('INSERT INTO admins (username, password) VALUES (:username, :password)');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);

            if ($stmt->execute()) {
                $_SESSION['success'] = 'Admin registered successfully';
                header('Location: admin_login.php');
                exit();
            }
        } catch (PDOException $e) {
            $errors['general'] = 'Database error: ' . $e->getMessage();
        }
    }

    $_SESSION['errors'] = $errors;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chewsday | Create Admin Account</title>
    <link rel="stylesheet" href="admin_regizter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <h1>Create Admin Account</h1>
        <?php if (isset($_SESSION['errors'])): ?>
            <div class="error">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php unset($_SESSION['errors']); endif; ?>

        <form method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group password">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="input-group">
                <i class="fas fa-key"></i>
                <input type="text" name="admin_key" placeholder="Admin Key" required>
            </div>
            <div class="additional-links">
                <button type="submit">Create</button>  
                <a href="admin_login.php" class="back-links">Admin Login</a>
                
        </div>
            
           
        </form>
    </div>
</body>
</html>
