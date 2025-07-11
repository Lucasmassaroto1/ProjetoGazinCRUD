<?php 
    require_once '../../../includes/config/conexao.php';
    session_start();
    $conexao = (new Conexao())->conectar();

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

    echo json_encode(['volume' => (int)$volume]);
?>