<?php
require 'vendor\autoload.php';
require_once 'database.php';
require_once 'validate.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class User{
    private $db;
    public function __construct(){
        $this->db = new Database();
    }

    public function validation($name,$email,$password,$conf){
        $nameError = Validation::validateNotEmpty($name,"Name cannot be empty");
        $emailError = Validation::validateEmail($email);
        $passError = Validation::validatePassword($password);
        $confError = Validation::confirmation($password,$conf);
        
        if($nameError || $emailError || $passError || $confError){
            return ['nameError' => $nameError, 'emailError' => $emailError, 'passwordError'=>$passError, 'confError'=>$confError];
        }
        if($this->usercheck($email)){
            return ['emailError'=>'Email Already Exixsts'];
        }
        return [];
    }
    public function register($name,$email,$password){
        $pass = md5($password);
        $sql = "Insert into users (user_name,email,pass) values (?,?,?)";
        $this->db->query($sql,"sss",[$name,$email,$pass]);
    }

    public function loggedin($email,$password){
        $emailError = Validation::validateEmail($email);
        $passError = Validation::validateNotEmpty($password,"Password cannot be empty");
        if($emailError || $passError){
            return ['emailError' => $emailError, 'passwordError'=>$passError];
        }

        $sql = "select * from users where email = ?";
        $stmt = $this->db->query($sql,"s",[$email]);
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if(!$user){
            return ['emailError'=>'Email does not exists'];
        }
        if($user['pass']!== md5($password)){
            return ['passwordError'=>'Incorrect Password!'];
        }
        return [];
    }

    public function usercheck($email){
        $sql = "Select * from users where email = ?";
        $stmt = $this->db->query($sql,"s",[$email]);
        return $stmt->get_result()->num_rows > 0;
    }

    public function userid($email){
        $sql = "Select * from users where email = ?";
        $stmt = $this->db->query($sql,"s",[$email]);
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        return $user ? $user['id'] : null; 
    }

    public function username($email){
        $sql = "Select * from users where email = ?";
        $stmt = $this->db->query($sql,"s",[$email]);
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        return $user ? $user['user_name'] : null; 
    }
    public function generateOTP($email){
        $otp = random_int(100000,999999);
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mahmad0449939@gmail.com';
        $mail->Password = 'kdlebohbzrncbafc';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('mahmad0449939@gmail.com');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $subject = "Important annoucment";
        $message = "Respected User, Your OTP is: ".$otp;
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();
        return $otp;
    }
}
?>