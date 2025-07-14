<?php 
    require_once '../../../includes/config/auth.php';
    require_once '../../../includes/config/conexao.php';

    $conexao =(new Conexao())->conectar();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $comando = $_POST['comando'];
        $descricao = $_POST['descricao'];
        $categoria = $_POST['categoria'];
        $exemplo = $_POST['exemplo'];
        $criado_por = $_SESSION['usuario_id'] ?? null;
        $usuario_tipo = $_SESSION['usuario_tipo'] ?? 'comun';
        $categorias_restritas = ['slash', 'padrao', 'hybrid'];

        $categoria_prefixo = strtolower(trim(explode('-', $categoria)[0]));
        if(in_array($categoria_prefixo, $categorias_restritas) && $usuario_tipo !== 'admin'){
            header('Location: ../views/painel/comandos.php?erro=nao_autorizado');
            exit;
        }
        $sql = "INSERT INTO conteudo (comando, descricao, categoria, exemplo, criado_por) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$comando, $descricao, $categoria, $exemplo, $criado_por]);

        header('location: ../../views/painel/comandos.php');
        exit;
    }
?>