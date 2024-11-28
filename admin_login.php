<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['texts']; // Updated input name
    $password = $_POST['passwords']; // Updated input name

    try {
        // Connect to the database
        $pdo = new PDO('mysql:host=localhost;dbname=hn', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch admin details by username
        $stmt = $pdo->prepare('SELECT id, username, password FROM admins WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify the password
            if (password_verify($password, $admin['password'])) {
                // Store admin details in the session
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin'] = [
                    'id' => $admin['id'],
                    'username' => $admin['username']
                ];
                header('Location: admin_home_page.php');
                exit();
            } else {
                $_SESSION['errors']['hn'] = 'Invalid username or password.';
            }
        } else {
            $_SESSION['errors']['hn'] = 'Invalid username or password.';
        }
    } catch (PDOException $e) {
        $_SESSION['errors']['hn'] = 'Database error: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chewsday | Admin Login</title>
    <link rel="stylesheet" href="admin_l0gin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
</head>
<body>

        <div class="form-container">

            <h1>Admin Login</h1>

            <form method="POST">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="texts" placeholder="Username" required>
                </div>
                <div class="input-group password">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="passwords" id="password" placeholder="Password" required>
                    <i id="eye" class="fa fa-eye"></i>
                </div>
                <button type="submit">Log In</button>
            </form>

            <!-- Additional links -->
            <div class="additional-links">
                <a href="admin_register.php" class="register-link">Admin Register</a>
                <a href="index.php" class="back-links">User Login</a>
            </div>
        </div>

        <script>
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eye');

            eyeIcon.addEventListener('click', () => {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                eyeIcon.classList.toggle('fa-eye-slash');
            });

            // Show error message in an alert if set
            <?php if (isset($_SESSION['errors']['hn'])): ?>
            alert("<?php echo $_SESSION['errors']['hn']; ?>");
            <?php unset($_SESSION['errors']['hn']); endif; ?>
        </script>
    </div>
</body>
</html>
