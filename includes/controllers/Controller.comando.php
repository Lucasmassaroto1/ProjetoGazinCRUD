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
    
    // ================ MUSICA ================

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