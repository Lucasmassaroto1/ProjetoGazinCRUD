<?php 
    require_once '../../config/auth.php';
    require_once '../../config/conexao.php';

    $conexao =(new Conexao())->conectar();

    // ================ CONTEUDO (COMANDOS) ================
    $stmt = $conexao->query("SELECT * FROM conteudo ORDER BY data_criacao DESC");
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total_commands = count($dados);

    // ================ PREFIXO_PERSONALIZADO ================
    $usuario_id = $_SESSION['usuario_id'];
    $stmt = $conexao->prepare("SELECT prefixo_customizado FROM prefixos WHERE usuario_id = ?");
    $stmt->execute([$usuario_id]);
    $prefixo_atual = $stmt->fetchColumn();

    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $usuario_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // ================ CONTEUDOS GERAIS ================
    $usuario_id = $_SESSION['usuario_id'];
    $usuario_tipo = $_SESSION['usuario_tipo'];

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
    <link rel="stylesheet" href="../../public/assets/style/filtro.css">
    <link rel="stylesheet" href="../../public/assets/style/cards.css">
    <link rel="stylesheet" href="../../public/assets/style/embed.css">
    <title>ByteCode Estatisticas</title>
</head>
<body>
    <?php $base_url = '../../'; $paginaAtual = 'estatistica'; include '../../includes/menu.php'?>
    
    <main class="conteudo">
        <?php include '../../includes/header.php';?>

        <?php include '../../includes/cardsesta.php';?>
    </main>
    <?php include '../../includes/footer.php'?>
    <script src="../../public/assets/script/filtro.js"></script>
    <script src="../../public/assets/script/tempo.js"></script>
    <script>
        function mostrarFormularioAdicionar(){
            document.getElementById('formAdicionar').style.display = 'block';      
        }
        function cancelarFormularioAdicionar(){
            document.getElementById('formAdicionar').style.display = 'none';
        }
    </script>
</body>
</html>