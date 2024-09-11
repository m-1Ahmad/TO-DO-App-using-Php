<?php
session_start();
require 'vendor\autoload.php';
require_once 'user.php';
if(loggedin()){
    header('location: homepage.php');
    exit;
}
$user = new User();
$error = [];
if($_SERVER['REQUEST_METHOD']=='POST'){
    $email = htmlspecialchars(trim($_POST['Email']));
    $pass = $_POST['Password'];
    $error = $user->loggedin($email,$pass);
    if(empty($error)){
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $user->userid($email);
        $_SESSION['name'] = $user->username($email);
        header('Location: homepage.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method = "post">
            <input type="email" name = "Email" placeholder="Email"
            value=<?php echo !empty($_POST['Email']) ? htmlspecialchars($email) : '';?>>
            <?php
                if(!empty($error['emailError'])){
                    echo '<span class= "error-message">'. $error['emailError'] . '</span>'; 
                }
            ?>
            <input type="password" name = "Password" placeholder="Password">
            <?php
                if(!empty($error['passwordError'])){
                    echo '<span class= "error-message">'. $error['passwordError'] . '</span>'; 
                }
            ?>
            <input type="submit" value="Login">
        </form>
        <div class="signup-link">
          <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
      </div>
    </div>
    
</body>
</html>