<?php 
    require_once '../../../includes/config/auth.php';
    require_once '../../../includes/config/conexao.php';

    $conexao =(new Conexao())->conectar();

    $usuario_id = $_SESSION['usuario_id'];
    $usuario_tipo = $_SESSION['usuario_tipo'];

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