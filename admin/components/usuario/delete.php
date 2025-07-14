<?php 
    require_once '../../../includes/config/auth.php';
    require_once '../../../includes/config/conexao.php';

    $conexao =(new Conexao())->conectar();

    $id = $_GET['id'] ?? null;

    if($id){
        $stmt = $conexao->prepare("DELETE FROM conteudo WHERE id = ?");
        $stmt->execute([$id]);
    }
    header('Location: ../../views/painel/comandos.php');
    exit;
?>