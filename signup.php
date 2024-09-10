<?php
session_start();
require_once 'user.php';
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']===true){
    header('location: homepage.php');
    exit;
}
$user = new User();
$error = [];
$name = $email = $pass = $c_pass = '';
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = htmlspecialchars(trim($_POST["Username"]));
    $email = htmlspecialchars(trim($_POST["Email"]));
    $pass = $_POST["Password"];
    $c_pass = $_POST["confirmation"];
    
    $error = $user->registration($name,$email,$pass,$c_pass);

    if (empty($error)){
        $_SESSION['loggedin'] = true;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $user->userid($email);
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <form  method = "post">
            <input type="text" name="Username" placeholder="Name" 
            value="<?php echo !empty($_POST['Username']) ? htmlspecialchars($name) : ''; ?>">
            <?php
                if(!empty($error['nameError'])){
                    echo '<span class ="error-message">' . $error['nameError'] . '</span>';
                }
            ?>
            <input type="text" name="Email" placeholder="Email"
            value="<?php echo !empty($_POST['Email']) ? htmlspecialchars($email) : ''; ?>">
            <?php
                if(!empty($error['emailError'])){
                    echo '<span class ="error-message">' . $error['emailError'] . '</span>';
                }
            ?>
            
            <input type="password" name="Password" placeholder="Password">
            <?php
                if(!empty($error['passwordError'])){
                    echo '<span class ="error-message">' . $error['passwordError'] . '</span>';
                }
            ?>
            <input type="password" name="confirmation" placeholder="Confirm Password">
            <?php
                if(!empty($error['confError'])){
                    echo '<span class ="error-message">' . $error['confError'] . '</span>';
                }
            ?>
            <input type="submit" value="Sign Up">
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>

