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
        $usuario_tipo = $_SESSION['usuario_tipo'];
        $categorias_restritas = ['slash', 'padrao', 'hybrid'];

        if(in_array($categoria, $categorias_restritas) && $usuario_tipo !== 'admin'){
            header('Location: ../pages/comandos.php?erro=nao_autorizado');
            exit;
        }
        $sql = "INSERT INTO conteudo (comando, descricao, categoria, exemplo, criado_por) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$comando, $descricao, $categoria, $exemplo, $criado_por]);

        header('location: ../pages/comandos.php');
        exit;
    }
?>