<?php
require_once '../../../includes/config/auth.php';
require_once '../../../includes/config/conexao.php';

$conexao = (new Conexao())->conectar();
session_start();

$usuario_id = $_SESSION['usuario_id'] ?? null;

// Verifica se os campos foram enviados
$titulo   = $_POST['titulo'] ?? null;
$mensagem = $_POST['mensagem'] ?? null;
$imagem   = $_POST['imagem'] ?? null;
$footer   = $_POST['footer'] ?? null;
$id       = $_POST['id'] ?? null;

// Validação básica
if(!$usuario_id || !$titulo || !$mensagem){
    die('Dados incompletos.');
}

try{
    // Verifica se já existe um welcome para este usuário
    $stmt = $conexao->prepare("SELECT id FROM welcome WHERE usuario_id = ?");
    $stmt->execute([$usuario_id]);
    $existe = $stmt->fetchColumn();

    if($id && $existe){
        // UPDATE
        $stmt = $conexao->prepare("UPDATE welcome SET titulo = ?, mensagem = ?, imagem = ?, footer = ? WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$titulo, $mensagem, $imagem, $footer, $id, $usuario_id]);
    }else{
        // INSERT
        $stmt = $conexao->prepare("INSERT INTO welcome (usuario_id, titulo, mensagem, imagem, footer) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$usuario_id, $titulo, $mensagem, $imagem, $footer]);
    }

    header('Location: ../../views/painel/comandos.php?mensagemEnviada=1');
    exit;

}catch(PDOException $e){
    echo "Erro ao salvar: " . $e->getMessage();
}
?>