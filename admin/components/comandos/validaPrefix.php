<?php 
    require_once '../../../includes/config/conexao.php';
    session_start();

    $usuario_id = $_SESSION['usuario_id'];
    $prefixo = $_POST['prefixo'];

    if(strlen($prefixo) > 1){
        die("Prefixo muito longo.");
    }

    $conexao = (new Conexao())->conectar();

    // Verifica se já existe prefixo para o usuário
    $stmt = $conexao->prepare("SELECT COUNT(*) FROM prefixos WHERE usuario_id = ?");
    $stmt->execute([$usuario_id]);

    if($stmt->fetchColumn() > 0){
        // Atualiza
        $stmt = $conexao->prepare("UPDATE prefixos SET prefixo_customizado = ? WHERE usuario_id = ?");
        $stmt->execute([$prefixo, $usuario_id]);
    }else{
        // Insere
        $stmt = $conexao->prepare("INSERT INTO prefixos (usuario_id, prefixo_customizado) VALUES (?, ?)");
        $stmt->execute([$usuario_id, $prefixo]);
    }

    header('Location: ../../views/painel/comandos.php');
    exit;
?>