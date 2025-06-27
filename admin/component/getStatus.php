<?php 
    require_once '../../config/conexao.php';

    $conexao = (new Conexao())->conectar();

    $stmt = $conexao->query("SELECT status, hora FROM status_bot WHERE id = 1");
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(['status' => $dados['status'], 'hora' => $dados['hora']]);
?>