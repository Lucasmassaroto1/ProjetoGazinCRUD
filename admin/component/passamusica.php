<?php
require_once '../../config/conexao.php';
session_start();
$conexao =(new Conexao())->conectar();

$usuario_id = $_SESSION['usuario_id'];

// Buscar a música que está em andamento
$stmt = $conexao->prepare("SELECT * FROM musica WHERE usuario_id = ? AND id_status = 1 ORDER BY id ASC LIMIT 1");
$stmt->execute([$usuario_id]);
$musica_atual = $stmt->fetch(PDO::FETCH_ASSOC);

if ($musica_atual) {
    // Atualizar status da música atual para "tocada" (ou outro status, exemplo id_status = 3)
    $stmt = $conexao->prepare("UPDATE musica SET id_status = 3 WHERE id = ?");
    $stmt->execute([$musica_atual['id']]);
}

// Pegar a próxima música na fila que está com status "em espera" (id_status = 2)
$stmt = $conexao->prepare("SELECT * FROM musica WHERE usuario_id = ? AND id_status = 2 ORDER BY id ASC LIMIT 1");
$stmt->execute([$usuario_id]);
$proxima_musica = $stmt->fetch(PDO::FETCH_ASSOC);

if ($proxima_musica) {
    // Atualizar para "em andamento" (id_status = 1)
    $stmt = $conexao->prepare("UPDATE musica SET id_status = 1 WHERE id = ?");
    $stmt->execute([$proxima_musica['id']]);
}

echo json_encode(['success' => true]);
?>
