<?php
class Database{
    private $conn;
    public function __construct(){
        $this->conn = new mysqli('localhost','root','','Form');
        if($this->conn->connect_error){
            die("Connection Error: ".$this->conn->connect_error);
        }
        $this->createUsersTable();
        $this->createTasksTable();
    }
    public function query($sql,$types="",$params = []){
        $stmt  = $this->conn->prepare($sql);
        if ($types && $params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt;
    }
    private function createUsersTable(){
        $sql = "CREATE TABLE IF NOT EXISTS users (
                    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    user_name VARCHAR(100) NOT NULL,
                    email VARCHAR(100) NOT NULL UNIQUE,
                    pass VARCHAR(155) NOT NULL
                )";
        $this->conn->query($sql);
    }

    private function createTasksTable(){
        $sql = "CREATE TABLE IF NOT EXISTS tasks (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT UNSIGNED NOT NULL,
                    task_name VARCHAR(155) NOT NULL,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                )";
        $this->conn->query($sql);
    }
    public function __destruct(){
        $this->conn->close();
    }
}
?>