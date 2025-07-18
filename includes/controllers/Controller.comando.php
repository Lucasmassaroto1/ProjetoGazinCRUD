<?php 
    require_once '../../../includes/config/auth.php';
    require_once '../../../includes/config/conexao.php';

    $conexao =(new Conexao())->conectar();

    $usuario_id = $_SESSION['usuario_id'];
    $usuario_tipo = $_SESSION['usuario_tipo'];

    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $usuario_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // ================ PREFIXO_PERSONALIZADO ================
    $usuario_id = $_SESSION['usuario_id'];
    $stmt = $conexao->prepare("SELECT prefixo_customizado FROM prefixos WHERE usuario_id = ?");
    $stmt->execute([$usuario_id]);
    $prefixo_atual = $stmt->fetchColumn();

    // ================ MENSAGEM DE BEM VINDO ================
    $stmtWelcome = $conexao->prepare("SELECT * FROM welcome WHERE usuario_id = ? ORDER BY id DESC LIMIT 1");
    $stmtWelcome->execute([$usuario_id]);
    $welcome = $stmtWelcome->fetch(PDO::FETCH_ASSOC);
    
    $mensagemEnviada = isset($_GET['mensagemEnviada']) && $_GET['mensagemEnviada'] == '1';
    if($mensagemEnviada){
        $welcomeInputs = [
            'titulo' => '',
            'mensagem' => '',
            'footer' => ''
        ];
    }else{
        $welcomeInputs = $welcome ?: ['titulo' => '', 'mensagem' => '', 'footer' => ''];
    }
?>