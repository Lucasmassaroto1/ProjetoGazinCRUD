<?php
    require_once '../config/conexao.php';
    $conexao = (new Conexao())->conectar();

    $usuario = 'admin';
    $senha = 'admin123';
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $tipo = 'admin';

    $sql = "INSERT INTO usuarios (usuario, senha, tipo) VALUES (?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$usuario, $senhaHash, $tipo]);

    echo "Admin criado com sucesso!";
?>