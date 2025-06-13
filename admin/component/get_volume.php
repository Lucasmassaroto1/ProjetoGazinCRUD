<?php 
    require_once '../../config/conexao.php';
    $conexao = (new Conexao())->conectar();

    $stmtVolume = $conexao->query("SELECT volume FROM configuracoes WHERE id = 1");
    $volume = $stmtVolume->fetchColumn();

    echo json_encode(['volume' => (int)$volume]);
?>