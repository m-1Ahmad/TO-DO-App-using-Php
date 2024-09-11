<?php
session_start();
require 'vendor\autoload.php';
require_once 'task.php';
if(!loggedin()){
    header('Location: login.php');
    exit;
}
$taskObj = new Task();
$error = '';
if($_SERVER['REQUEST_METHOD']=="POST"){
    $taskname = $_POST['task'];
    $userid = $_SESSION['id'];
    $error = $taskObj->addtask($userid,$taskname);
    if(empty($error)){
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
    <title>Add Task</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Add a New Task</h2>
        <form method="POST" action="add.php">
            <input type="text" name="task" id="task" placeholder="Enter your task">
            <?php
                if(!empty($error)){
                    echo '<span class= "error-message">'. $error . '</span><br>'; 
                }
            ?>
            <button type="submit" name="add_task">Add</button>
            <a href="homepage.php"><button type="button">Cancel</button></a>
        </form>
    </div>

</body>
</html>