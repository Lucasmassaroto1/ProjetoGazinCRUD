<?php 
    require_once '../../config/conexao.php';

    $conexao = (new Conexao())->conectar();

    $stmt = $conexao->query("SELECT status FROM status_bot WHERE id = 1");
    $status = $stmt->fetchColumn();

    echo json_encode(['status' => $status])
?>