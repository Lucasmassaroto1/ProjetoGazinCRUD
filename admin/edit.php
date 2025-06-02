<?php 
    require_once '../includes/auth.php';
    require_once '../config/conexao.php';

    $conexao =(new Conexao())->conectar();


    $id = $_GET['id'] ?? null;

    if(!$id){
        header('Location: dashboard.php');
        exit;
    }

    $stmt = $conexao->prepare("SELECT * FROM conteudo WHERE id = ?");
    $stmt->execute([$id]);
    $comando = $stmt->fetch();

    if(!$comando){
        echo 'Comando não encontrado';
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $novoComando = $_POST['comando'];
        $descricao = $_POST['descricao'];
        $categoria = $_POST['categoria'];
        $exemplo = $_POST['exemplo'];

        $sql = "UPDATE conteudo SET comando = ?, descricao = ?, categoria = ?, exemplo = ? WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$novoComando, $descricao, $categoria, $exemplo, $id]);

        header('Location: dashboard.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bytecrud - Editar Comandos</title>
</head>
<body>
    <h2>Editar Comando</h2>
    <form method="post">
        <label>Comando:</label><br>
        <input type="text" name="comando" value="<?= htmlspecialchars($comando['comando']) ?>" required><br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao" required><?= htmlspecialchars($comando['descricao']) ?></textarea><br><br>

        <label>Categoria:</label><br>
        <input type="text" name="categoria" value="<?= htmlspecialchars($comando['categoria']) ?>" required><br><br>

        <label>Exemplo de uso:</label><br>
        <input type="text" name="exemplo" value="<?= htmlspecialchars($comando['exemplo']) ?>"><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>

    <p><a href="dashboard.php">← Voltar para dashboard</a></p>

</body>
</html>