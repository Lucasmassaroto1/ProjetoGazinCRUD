<?php 
    require_once '../../../includes/config/auth.php';
    require_once '../../../includes/config/conexao.php';

    $conexao =(new Conexao())->conectar();

    $id = $_GET['id'] ?? null;

    if($id){
        // Verifica se tem algum registro
        $check = $conexao->prepare("SELECT * FROM musica WHERE id = ?");
        $check->execute([$id]);
        
        if($check->rowCount()){
            $stmt = $conexao->prepare("DELETE FROM musica WHERE id = ?");
            $stmt->execute([$id]);
        }
    }
    header('Location: ../../views/painel/comandos.php');
    exit;
?>