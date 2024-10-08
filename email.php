<?php
session_start();


require_once 'user.php';
require_once 'validate.php';
require 'vendor\autoload.php';
if(loggedin()){
    header('location: homepage.php');
    exit;
}else if(!signnedup()){
    header('Location: signup.php');
    exit;
}

if($_SERVER['REQUEST_METHOD']=="POST"){
    $pass = $_POST['pass'];
    $user = new User();
    $pError = Validation::validateNotEmpty($pass,"OTP cannot be empty!");
    if(empty($pError)){
        if($pass == $_SESSION['OTP']){
            $user->register($_SESSION['name'],$_SESSION['email'],$_SESSION['pass']);
            $_SESSION['id']= $user->userid($_SESSION['email']);
            $_SESSION['loggedin'] = true;
            $_SESSION['signup'] = false;
            header('Location:homepage.php');
            exit();
        }else{
            $pError = 'OTP Does not match!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form method="POST" action="email.php">
            <h3>OTP Sent to Email</h3>
            <label for="email">OTP:</label>
            <input type="text" name="pass" placeholder = "Password">
            <?php
                if(!empty($pError)){
                    echo '<span class ="error-message">' . $pError . '</span><br>';
                }
            ?>
            <input type="submit" value="OK" />
        </form>
    </div>
</body>
</html>