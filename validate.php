<?php
class Validation{
    public static function validateNotEmpty($value,$message){
        return empty($value) ? $message : '';
    }
    public static function validateEmail($email){
        if(empty($email)){
            return "Email cannot be Empty!";
        }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            return "Email Format is incorrect!";
        }
        return '';
    }
    public static function validatePassword($password){
        if (empty($password)) {
            return "Password cannot be empty!";
        } elseif (strlen($password) < 5) {
            return "Password cannot be less than 5 characters!";
        }
        return '';
    }
    public static function confirmation($pass,$conf){
        if($conf !== $pass){
            return "Password do not Match";
        }elseif(empty($conf)){
            return "Confirmation Password cannot be empty!";
        }
        return '';
    }
}
?>