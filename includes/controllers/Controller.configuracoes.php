<?php 
    require_once '../../../includes/config/auth.php';
    require_once '../../../includes/config/conexao.php';

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

?>