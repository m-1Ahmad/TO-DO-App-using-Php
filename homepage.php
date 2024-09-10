<?php
session_start();
require_once 'task.php';
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('Location: login.php');
    exit;
}
$taskObj = new Task();
$userid = $_SESSION['id'];

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

if(isset($_POST['delete'])){
    $taskid = $_POST['delete'];
    $taskObj->deleteTask($taskid,$userid);
    header('Location: homepage.php');
    exit();
}

if(isset($_POST['edit_task'])){
    $taskid = $_POST['edited_task_id'];
    $new_task_name = $_POST['edited_task'];
    $taskObj->updateTask($taskid,$new_task_name,$userid);
    header('Location: homepage.php');
    exit();
}

$tasks = $taskObj->getTasks($userid);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <div class="header">
            <form class="logout-form" method="POST">
                <button type="submit" name="logout">Logout</button>
            </form>
            <h1>Welcome to the Home Page</h1>
            <p>Hello, <?php echo $_SESSION['name']; ?>!</p>
            <p>Email: <?php echo $_SESSION['email']; ?>!</p>
        </div>
        <h2>Your Tasks</h2>
        <ul class="task-list">
            <?php foreach ($tasks as $task): ?>
                <li>
                    <div class="task-container">
                        <span class="task-name"><?php echo htmlspecialchars($task['task_name']); ?></span>
                        <form method="post" action="homepage.php" style="display:inline;">
                            <button type="submit" name="edit" value="<?php echo $task['id']; ?>">Edit</button>
                            <button type="submit" name="delete" value="<?php echo $task['id']; ?>">Delete</button>
                        </form>
                        <?php if (isset($_POST['edit']) && $_POST['edit'] == $task['id']): ?>
                            <form method="post" action="homepage.php">
                                <input type="hidden" name="edited_task_id" value="<?php echo $task['id']; ?>">
                                <input type="text" name="edited_task" value="<?php echo htmlspecialchars($task['task_name']); ?>" required>
                                <button type="submit" name="edit_task">OK</button>
                                <button type="button" onclick="window.location.href='homepage.php'">Cancel</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="add.php"><button>Add Task</button></a>
    </div>

</body>
</html>
