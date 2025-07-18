<?php 
    require_once '../includes/config/conexao.php';

    $conexao =(new Conexao())->conectar();

    // ================ PAGINAÇÃO ================
    $limite = 3;
    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $pagina = $pagina < 1 ? 1 : $pagina;
    $offset = ($pagina - 1) * $limite;

    // ========== Lista todos os comandos ==========
    $stmt = $conexao->prepare("SELECT c.*, u.usuario AS autor FROM conteudo c JOIN usuarios u ON c.criado_por = u.id ORDER BY c.data_criacao DESC LIMIT :limite OFFSET :offset");
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmtTotal = $conexao->query("SELECT COUNT(*) AS total FROM conteudo WHERE categoria NOT LIKE 'padrao%' AND categoria NOT LIKE 'slash%' AND categoria NOT LIKE 'hybrid%'");
    $total = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPaginas = ceil($total / $limite);
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
    $stmt = $conexao->query("SELECT prefixo_customizado FROM prefixos ORDER BY id DESC LIMIT 1");
    $prefixo_atual = $stmt->fetchColumn();

    // ================ WELCOME ================
    $conteudos = [];

    if(isset($_SESSION['usuario_id'], $_SESSION['usuario_tipo'])){
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

    }else{
        // Consulta pública padrão (sem filtrar por autor)
        $sql = "SELECT c.*, u.usuario AS autor FROM conteudo c JOIN usuarios u ON c.criado_por = u.id ORDER BY c.data_criacao DESC";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $conteudos = $stmt->fetchAll();

        // Pega a última mensagem pública (sem usuário)
        $stmtWelcome = $conexao->prepare("SELECT * FROM welcome ORDER BY id DESC LIMIT 1");
        $stmtWelcome->execute();
        $welcome = $stmtWelcome->fetch(PDO::FETCH_ASSOC);
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cargo_auto'])){
        $_SESSION['cargo_auto'] = $_POST['cargo_auto'];
    }
    $mensagemOriginal = $welcome['mensagem'] ?? '';
    $cargo_auto = $_SESSION['cargo_auto'] ?? '@Membro'; // padrão
    $mensagemComCargo = str_replace('{user.mention}', '<span class="cargo">' . htmlspecialchars($cargo_auto) . '</span>', $mensagemOriginal);

    // ================ MUSICA ================
    $stmtmusic = $conexao->prepare("SELECT m.*, s.nome AS nome_status FROM musica m JOIN status s ON m.id_status = s.id WHERE usuario_id = 1 AND m.id_status IN (1, 2) ORDER BY m.id_status ASC, m.id ASC");
    $stmtmusic->execute();
    $musica = $stmtmusic->fetchAll(PDO::FETCH_ASSOC);
?>