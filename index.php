<?php
session_start();
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chewsday | Log In</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="layout.css">

</head>

<body>
    <div class="background">
        
        <div class="profile-check" id="signIn">
            <h1 class="form-title">Chewsday</h1>
            <h2>Designed By Justin Nam</h2>
            <?php
            if (isset($errors['login'])) {
                echo '<div class="error-main">
                            <p>' . $errors['login'] . '</p>
                          </div>';
                unset($errors['login']);
            }
            ?>
            <form method="POST" action="user-account.php">
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="Please enter your Email" required>
                    <?php
                    if (isset($errors['email'])) {
                        echo ' <div class="error">
                                <p>' . $errors['email'] . '</p>
                              </div>';
                    }
                    ?>
                </div>
                <div class="input-group password">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Please enter your Password" required>
                    <i id="eye" class="fa fa-eye"></i>
                    <?php
                    if (isset($errors['password'])) {
                        echo ' <div class="error">
                                <p>' . $errors['password'] . '</p>
                              </div>';
                    }
                    ?>
                </div>
               
                <input type="submit" class="btn" value="Log In" name="login">
            </form>


            

            <div class="contact-admin">
                <a href="mailto:nguyenhongnamjt@gmail.com" class="contact_admin_button">Contact Admin</a>
            </div>
            
            <div class="admin-login">
            <a href="admin_login.php" class="admin_login_button">Admin Login</a>

            </div>
            <div class="links">
                <p>Don't have an account? </p>
                <a href="register.php">Create Account</a>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const passwordField = document.getElementById("password");
                const toggleIcon = document.getElementById("eye");

                toggleIcon.addEventListener("click", function () {
                    const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
                    passwordField.setAttribute("type", type);

                    // Toggle icon classes for visibility state
                    this.classList.toggle("fa-eye");
                    this.classList.toggle("fa-eye-slash");
                });
            });
        </script>
    </div>
</body>

</html>
<?php
if (isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}
?>
