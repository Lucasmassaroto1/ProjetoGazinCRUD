<?php 
    session_start();
    session_destroy();
    header('Location: ../../views/auth/login.php');
    exit;
?>
<?php $base_url = '../../../';?>