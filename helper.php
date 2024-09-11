<?php
if(!function_exists('loggedin')){
    function loggedin(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_SESSION['loggedin'])){
            return $_SESSION['loggedin'] ? true : false;
        }
    }
}
if(!function_exists('signnedup')){
    function signnedup(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_SESSION['signup'])){
            return $_SESSION['signup'] ? true : false;
        }
    }
}
?>