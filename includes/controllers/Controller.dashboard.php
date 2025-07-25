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

    // ================ PAGINAÇÃO ================
    $limite = 3;
    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $pagina = max(1, $pagina);
    $offset = ($pagina - 1) * $limite;

    // ================ CONSULTA COM FILTRO ================
    if($usuario_tipo === 'admin'){
        $stmt = $conexao->prepare("SELECT c.*, u.usuario AS autor FROM conteudo c JOIN usuarios u ON c.criado_por = u.id ORDER BY c.data_criacao DESC LIMIT :limite OFFSET :offset");

        $stmtTotal = $conexao->query("SELECT COUNT(*) AS total FROM conteudo WHERE categoria NOT LIKE 'padrao%' AND categoria NOT LIKE 'slash%' AND categoria NOT LIKE 'hybrid%'");
    }else{
        $stmt = $conexao->prepare("SELECT c.*, u.usuario AS autor FROM conteudo c JOIN usuarios u ON c.criado_por = u.id WHERE c.criado_por = :usuario_id ORDER BY c.data_criacao DESC LIMIT :limite OFFSET :offset");

        $stmtTotal = $conexao->prepare("SELECT COUNT(*) AS total FROM conteudo WHERE criado_por = :usuario_id AND categoria NOT LIKE 'padrao%' AND categoria NOT LIKE 'slash%' AND categoria NOT LIKE 'hybrid%'");
        $stmtTotal->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
    }

    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmtTotal->execute();
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
    
    // ================ TEMA DO SITE ================
    $tema = 'azul';
    if(isset($_SESSION['usuario_id'])){
    $stmt = $conexao->prepare("SELECT tema FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    $res = $stmt->fetch();
    if($res && in_array($res['tema'], ['azul', 'roxo', 'verde'])){
        $tema = $res['tema'];
    }
}
?>