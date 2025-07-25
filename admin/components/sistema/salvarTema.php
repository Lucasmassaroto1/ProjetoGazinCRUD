<?php 
    session_start();
    require_once '../../../includes/config/conexao.php';

    $conexao =(new Conexao())->conectar();

    if(isset($_POST['tema'], $_SESSION['usuario_id'])){
        $tema = $_POST['tema'];
        $id = $_SESSION['usuario_id'];

        $sql = 'UPDATE usuarios SET tema = :tema WHERE id = :id';
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':tema', $tema);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }
?>