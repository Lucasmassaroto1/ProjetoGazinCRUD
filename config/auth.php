<?php 
    if(session_status() === PHP_SESSION_NONE){
    session_start();
    }
    if(!isset($_SESSION['usuario_id'])){
        header('Location: ../admin/login.php');
        exit;
    }
?>