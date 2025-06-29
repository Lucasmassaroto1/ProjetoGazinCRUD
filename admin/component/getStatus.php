<?php 
    require_once '../../config/conexao.php';

    $conexao = (new Conexao())->conectar();

    // NÃO TROCAR TIMEZONE!!!!!!!!
    date_default_timezone_set('America/Sao_Paulo');
    
    $stmt = $conexao->query("SELECT status, hora FROM status_bot WHERE id = 1");
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(['status' => $dados['status'], 'hora' => $dados['hora']]);
?>