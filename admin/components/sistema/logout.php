<?php 
    session_start();
    session_destroy();
    header('Location: ../../pages/auth/login.php');
    exit;
?>
<?php $base_url = '../../../';?>