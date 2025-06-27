<?php 
    require_once '../../config/auth.php';
    require_once '../../config/conexao.php';

    $conexao =(new Conexao())->conectar();

    $usuario_id = $_SESSION['usuario_id'];
    
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$usuario_id]);
    $user = $stmt->fetch();

    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $usuario_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $mensagem = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $novo_nome = trim($_POST['nome'] ?? '');
        $novo_email = trim($_POST['email'] ?? '');

        $campos = [];
        $valores = [];

        if(!empty($novo_nome) && $novo_nome != $user['usuario']){
            $campos[] = "usuario = ?";
            $valores[] = $novo_nome;
        }

        if(!empty($novo_email) && $novo_email != $user['email']){
            $campos[] = "email = ?";
            $valores[] = $novo_email;
        }

        if(count($campos) > 0){
            $valores[] = $usuario_id;
            $sql = "UPDATE usuarios SET ".implode(", ", $campos)." WHERE id = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->execute($valores);

            if(!empty($novo_nome)) $_SESSION['usuario_nome'] = $novo_nome;
            if(!empty($novo_email)) $_SESSION['usuario_email'] = $novo_email;

            $mensagem = "<p style='color:green'>Dados atualizados com sucesso!</p>";
            header("Refresh: 1");
        }else{
            $mensagem = "<p style='color:orange'>Nenhuma alteração detectada.</p>";
        }
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
    <link rel="shortcut icon" href="../../public/img/Favicon/favicon.ico" type="image/x-icon">
    <!-- ======== FONT & ICONS ======== -->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- ======== ESTILO SEPARADOS ======== -->
    <link rel="stylesheet" href="../../public/assets/style/dash.css">
    <link rel="stylesheet" href="../../public/assets/style/cards.css">
    <link rel="stylesheet" href="../../public/assets/style/embed.css">

    <link  href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <title>ByteCode - Perfil</title>
</head>
<body>
    <?php $base_url = '../../'; $paginaAtual = 'perfil'; include '../../includes/menu.php'?>
    <main class="conteudo">
        <?php include '../../includes/header.php';?>
        <?php include '../../includes/cardsperfil.php';?>
        <?php include '../../includes/footer.php'?>
    </main>
</body>
</html>