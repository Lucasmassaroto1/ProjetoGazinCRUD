<?php 
    require_once '../../../config/auth.php';
    require_once '../../../config/conexao.php';

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
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Um simples DashBoard para configurar o ByteCode">
    <meta name="author" content="Lucas Massaroto">
    <!-- ======== FAVICON ======== -->
    <link rel="shortcut icon" href="../../../public/img/Favicon/favicon.ico" type="image/x-icon">
    <!-- ======== ESTILO, FONT & ICONS ======== -->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../public/assets/style/main.css">
    <title>ByteCode Comandos</title>
</head>
<body>
    <?php $base_url = '../../../'; $paginaAtual = 'comandos'; include '../../../includes/layout/menu.php'?>
    <main class="conteudo">
        <?php include '../../../includes/layout/header.php';?>
        <?php include '../../../includes/cards/comando.php'?>
    </main>
    <?php include '../../../includes/layout/footer.php'?>
</body>
</html>