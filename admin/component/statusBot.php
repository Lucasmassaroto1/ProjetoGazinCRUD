<?php
session_start();
require_once '../../config/auth.php';
require_once '../../config/conexao.php';

$conexao = (new Conexao())->conectar();

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['erro' => 'Não autorizado']);
    exit;
}

if ($_SESSION['usuario_tipo'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['erro' => 'Acesso negado. Permissão insuficiente.']);
    exit;
}

$status = $_POST['status'] ?? null;
if($status === 'ligar'){
    $novoStatus = 'online';
    $hora = date('Y-m-d H:i:s');
}elseif($status === 'desligar'){
    $novoStatus = 'offline';
    $hora = null;
}else{
    http_response_code(400);
    echo json_encode(['erro' => 'Parâmetro inválido']);
    exit;
}

// Atualiza o status e a hora no banco
$stmt = $conexao->prepare("UPDATE status_bot SET status = ?, hora = ? WHERE id = 1");
$stmt->execute([$novoStatus, $hora]);

echo json_encode([
    'mensagem' => 'Bot ' . ($novoStatus === 'online' ? 'ligado' : 'desligado') . ' com sucesso!',
    'status' => $novoStatus,
    'hora' => $hora
]);



/* session_start();
require_once '../../config/auth.php';
require_once '../../config/conexao.php';

$conexao = (new Conexao())->conectar();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['erro' => 'Não autorizado']);
    exit;
}

// Verifica se é admin
if ($_SESSION['usuario_tipo'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['erro' => 'Acesso negado. Permissão insuficiente.']);
    exit;
}

// Pega o status enviado
$status = $_POST['status'] ?? null;

if ($status === 'ligar') {
    $novoStatus = 'online';
} elseif ($status === 'desligar') {
    $novoStatus = 'offline';
} else {
    http_response_code(400);
    echo json_encode(['erro' => 'Parâmetro inválido']);
    exit;
}

// Atualiza o status no banco
$stmt = $conexao->prepare("UPDATE status_bot SET status = ? WHERE id = 1");
$stmt->execute([$novoStatus]);

echo json_encode(['mensagem' => 'Bot ' . ($novoStatus === 'online' ? 'ligado' : 'desligado') . ' com sucesso!', 'status' => $novoStatus]); */
?>
