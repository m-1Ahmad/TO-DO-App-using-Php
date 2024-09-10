<?php
require_once 'database.php';
require_once 'validate.php';
class Task{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }
    public function addtask($userId,$task_name){
        $taskError = Validation::validateNotEmpty($task_name,"Task cannot be empty!");
        if($taskError){
            return $taskError;
        }
        $task_name = htmlspecialchars($task_name);
        $sql = "Insert into tasks (user_id,task_name) values (?,?)";
        $this->db->query($sql,"is",[$userId,$task_name]);

        return '';
    }

    public function deleteTask($taskid,$userId){
        $sql = "Delete from tasks where id = ? AND user_id = ?";
        $this->db->query($sql,"ii",[$taskid,$userId]);
    }

    public function updateTask($taskid,$task_name,$userId){
        $task_name = htmlspecialchars($task_name);
        $sql = "Update tasks set task_name = ? where id = ? AND user_id = ?";
        $this->db->query($sql,"sii",[$task_name,$taskid,$userId]);
    }

    public function getTasks($userId){
        $sql = "Select * from tasks where user_id = ?";
        $stmt = $this->db->query($sql,"i",[$userId]);
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }else{
            return [];
        }
    }
}
?>