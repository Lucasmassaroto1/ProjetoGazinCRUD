<?php 
    require_once '../../config/auth.php';
    require_once '../../config/conexao.php';

    $conexao =(new Conexao())->conectar();
    
    $usuario_id = $_SESSION['usuario_id'];
    
    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $usuario_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // ================ MENSAGEM DE BEM VINDO ================
    $stmtWelcome = $conexao->prepare("SELECT * FROM welcome WHERE usuario_id = ? ORDER BY id DESC LIMIT 1");
    $stmtWelcome->execute([$usuario_id]);
    $welcome = $stmtWelcome->fetch(PDO::FETCH_ASSOC);

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cargo_auto'])){
        $_SESSION['cargo_auto'] = $_POST['cargo_auto'];
    }
    $mensagemOriginal = $welcome['mensagem'] ?? '';
    $cargo_auto = $_SESSION['cargo_auto'] ?? '@Membro'; // padrão
    $mensagemComCargo = str_replace('{user.mention}', '<span class="cargo">' . htmlspecialchars($cargo_auto) . '</span>', $mensagemOriginal);

    // ================ MUSICA E VOLUME ================
    $stmtmusic = $conexao->prepare("SELECT m.*, s.nome AS nome_status FROM musica m JOIN status s ON m.id_status = s.id WHERE usuario_id = ? AND m.id_status IN (1, 2) ORDER BY m.id_status ASC, m.id ASC");
    $stmtmusic->execute([$usuario_id]);
    $musica = $stmtmusic->fetchAll(PDO::FETCH_ASSOC);


    $usuario_id = $_SESSION['usuario_id'];

    $stmtVolume = $conexao->prepare("SELECT volume FROM configuracoes WHERE usuario_id = :usuario_id");
    $stmtVolume->execute([':usuario_id' => $usuario_id]);

    $volume = $stmtVolume->fetchColumn();
    if($volume === false){
        $volume = 50;

        $stmtInserir = $conexao->prepare("INSERT INTO configuracoes (usuario_id, volume) VALUES (:usuario_id, :volume)");
        $stmtInserir->execute([
            ':usuario_id' => $usuario_id,
            ':volume' => $volume
        ]);
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
    <title>ByteCode Configurações</title>
</head>
<body>
    <?php $base_url = '../../'; $paginaAtual = 'configuracoes'; include '../../includes/menu.php'?>
    
    <main class="conteudo">
        <?php include '../../includes/header.php';?>
        <?php include '../../includes/cardconfig.php';?>
    </main>
    <?php include '../../includes/footer.php'?>
    <script src="../../public/assets/script/musica.js"></script>
</body>
</html>