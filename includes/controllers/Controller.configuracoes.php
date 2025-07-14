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

    /* // ================ MUSICA E VOLUME ================
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
    } */
?>