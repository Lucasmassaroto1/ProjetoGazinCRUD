<?php 
    require_once '../../config/auth.php';
    require_once '../../config/conexao.php';

    $conexao =(new Conexao())->conectar();

    $usuario_id = $_SESSION['usuario_id'];
    $usuario_tipo = $_SESSION['usuario_tipo'];

    // ================ PAGINAÇÃO ================
    $limite = 3;

    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $pagina = $pagina < 1 ? 1 : $pagina;

    $offset = ($pagina - 1) * $limite;

    $stmtmusic = $conexao->prepare("SELECT m.*, s.nome AS nome_status FROM musica m JOIN status s ON m.id_status = s.id WHERE usuario_id = ? ORDER BY m.id ASC, m.id_status ASC LIMIT ? OFFSET ?");

    $stmtmusic->bindValue(1, $usuario_id, PDO::PARAM_INT);
    $stmtmusic->bindValue(2, $limite, PDO::PARAM_INT);
    $stmtmusic->bindValue(3, $offset, PDO::PARAM_INT);
    $stmtmusic->execute();
    $musica = $stmtmusic->fetchAll(PDO::FETCH_ASSOC);

    $stmtTotal = $conexao->prepare("SELECT COUNT(*) AS total FROM musica WHERE usuario_id = ?");
    $stmtTotal->execute([$usuario_id]);
    $total = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

    $totalPaginas = ceil($total / $limite);

    // ================ COMANDOS ================
    if($usuario_tipo === 'admin'){
        $stmt = $conexao->prepare("SELECT c.*, u.usuario AS autor  conteudo c JOIN usuarios u ON c.criado_por = u.id ORDER BY c.data_criacao DESC");
        $stmtTotal = $conexao->query("SELECT COUNT(*) AS total FROM conteudo WHERE categoria NOT LIKE 'padrao%' AND categoria NOT LIKE 'slash%' AND categoria NOT LIKE 'hybrid%'");
    }else{
        $stmt = $conexao->prepare("SELECT c.*, u.usuario AS autor FROM conteudo c JOIN usuarios u ON c.criado_por = u.id WHERE c.criado_por = :usuario_id ORDER BY c.data_criacao DESC");
        $stmtTotal = $conexao->prepare("SELECT COUNT(*) AS total FROM conteudo WHERE criado_por = :usuario_id AND categoria NOT LIKE 'padrao%' AND categoria NOT LIKE 'slash%' AND categoria NOT LIKE 'hybrid%'");
        $stmtTotal->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
    }
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmtTotal->execute();
    $total = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $total_commands = $total;

    // ================ TOTAL DE COMANDOS POR CATEGORIA ================
    $stmtPadrao = $conexao->prepare("SELECT COUNT(*) FROM conteudo WHERE categoria LIKE 'padrao%'");
    $stmtPadrao->execute();
    $commands_padrao = $stmtPadrao->fetchColumn();

    $stmtSlash = $conexao->prepare("SELECT COUNT(*) FROM conteudo WHERE categoria LIKE 'slash%'");
    $stmtSlash->execute();
    $slash_commands_padrao = $stmtSlash->fetchColumn();

    $stmtHybrid = $conexao->prepare("SELECT COUNT(*) FROM conteudo WHERE categoria LIKE 'hybrid%'");
    $stmtHybrid->execute();
    $hybrid_commands_padrao = $stmtHybrid->fetchColumn();

    // ================ PREFIXO_PERSONALIZADO ================
    $stmt = $conexao->prepare("SELECT prefixo_customizado FROM prefixos WHERE usuario_id = ?");
    $stmt->execute([$usuario_id]);
    $prefixo_atual = $stmt->fetchColumn();

    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $usuario_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($usuario_tipo === 'admin'){
        $sql = "SELECT c.*, u.usuario AS autor FROM conteudo c JOIN usuarios u ON c.criado_por = u.id ORDER BY c.data_criacao DESC";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
    }else{
        $sql = "SELECT c.*, u.usuario AS autor FROM conteudo c JOIN usuarios u ON c.criado_por = u.id WHERE c.criado_por = ? ORDER BY c.data_criacao DESC";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$usuario_id]);
    }
    $conteudos = $stmt->fetchAll();

    $stmtWelcome = $conexao->prepare("SELECT * FROM welcome WHERE usuario_id = ? ORDER BY id DESC LIMIT 1");
    $stmtWelcome->execute([$usuario_id]);
    $welcome = $stmtWelcome->fetch(PDO::FETCH_ASSOC);

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cargo_auto'])){
        $_SESSION['cargo_auto'] = $_POST['cargo_auto'];
    }
    $mensagemOriginal = $welcome['mensagem'] ?? '';
    $cargo_auto = $_SESSION['cargo_auto'] ?? '@Membro'; // padrão
    $mensagemComCargo = str_replace('{user.mention}', '<span class="cargo">' . htmlspecialchars($cargo_auto) . '</span>', $mensagemOriginal);
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
    <!-- ======== ESTILO, FONT & ICONS ======== -->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/assets/style/dash.css">
    <title>ByteCode Estatisticas</title>
</head>
<body>
    <?php $base_url = '../../'; $paginaAtual = 'estatistica'; include '../../includes/menu.php'?>
    <main class="conteudo">
        <?php include '../../includes/header.php';?>
        <?php include '../../includes/card_estatistica.php';?>
    </main>
    <?php include '../../includes/footer.php'?>
</body>
</html>