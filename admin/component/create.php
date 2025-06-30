<?php 
    require_once '../../config/auth.php';
    require_once '../../config/conexao.php';

    $conexao =(new Conexao())->conectar();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $comando = $_POST['comando'];
        $descricao = $_POST['descricao'];
        $categoria = $_POST['categoria'];
        $exemplo = $_POST['exemplo'];
        $criado_por = $_SESSION['usuario_id'];

        $sql = "INSERT INTO conteudo (comando, descricao, categoria, exemplo, criado_por) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$comando, $descricao, $categoria, $exemplo, $criado_por]);

        header('Location: ../pages/comandos.php');
    exit;
}
?>