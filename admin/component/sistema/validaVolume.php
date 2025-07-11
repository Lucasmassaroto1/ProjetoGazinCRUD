<?php 
    require_once '../../../includes/config/conexao.php';
    session_start();
    $conexao = (new Conexao())->conectar();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $volume = isset($_POST['volume']) ? (int)$_POST['volume'] : 50;
        $usuario_id = $_SESSION['usuario_id'];

        if($volume < 0) $volume = 0;
        if($volume > 100) $volume = 100;

        /* $stmt = $conexao->prepare("UPDATE configuracoes SET volume = :volume WHERE id = 1");
        $stmt->execute([':volume' => $volume]); */

        $stmt = $conexao->prepare("SELECT id FROM configuracoes WHERE usuario_id = :usuario_id");
        $stmt->execute([':usuario_id' => $usuario_id]);
        $existe = $stmt->fetch();

        if($existe){
            $stmt = $conexao->prepare("UPDATE configuracoes SET volume = :volume WHERE usuario_id = :usuario_id");
        }else{
            $stmt = $conexao->prepare("INSERT INTO configuracoes (usuario_id, volume) VALUES (:usuario_id, :volume)");
        }

        $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':volume' => $volume
        ]);
        
        echo json_encode(['status' => 'sucesso', 'volume' => $volume]);
}else{
    echo json_encode(['status' => 'erro']);
}
?>