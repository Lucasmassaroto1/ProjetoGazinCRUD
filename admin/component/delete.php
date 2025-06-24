<?php 
    require_once '../../config/auth.php';
    require_once '../../config/conexao.php';

    $conexao =(new Conexao())->conectar();

    $id = $_GET['id'] ?? null;

    if($id){
        $stmt = $conexao->prepare("DELETE FROM conteudo WHERE id = ?");
        $stmt->execute([$id]);
    }
    header('Location: ../pages/comandos.php');
    exit;
?>