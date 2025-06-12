<?php 
    require_once '../config/conexao.php';
    $conexao = (new Conexao())->conectar();

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $volume = isset($_POST['volume']) ? (int)$_POST['volume'] : 50;

        if($volume < 0) $volume = 0;
        if($volume > 100) $volume = 100;

        $stmt = $conexao->prepare("UPDATE configuracoes SET volume = :volume WHERE id = 1");
        $stmt->execute([':volume' => $volume]);

        echo json_encode(['status' => 'sucesso', 'volume' => $volume]);
}else{
    echo json_encode(['status' => 'erro']);
}
?>