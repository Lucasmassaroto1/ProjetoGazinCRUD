<?php
    require_once '../includes/config/conexao.php';
    $conexao = (new Conexao())->conectar();

    $usuario = 'bytecode';
    $senha = 'admin123';
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $tipo = 'admin';

    $sql = "INSERT INTO usuarios (usuario, senha, tipo) VALUES (?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$usuario, $senhaHash, $tipo]);

    echo "Admin criado com sucesso!";
?>