<?php 
    require_once '../includes/auth.php';
    require_once '../config/conexao.php';

    $conexao =(new Conexao())->conectar();

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $comando = $_POST['comando'];
        $descricao = $_POST['descricao'];
        $categoria = $_POST['categoria'];
        $exemplo = $_POST['exemplo'];

        $sql = "INSERT INTO conteudo (comando, descricao, categoria, exemplo) VALUES (?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$comando, $descricao, $categoria, $exemplo]);

        header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Bytecrud - Adicionar Comando</title>
</head>
<body>
    <h2>Adicionar Novo Comando</h2>
    <form method="post">
        <label>Comando:</label><br>
        <input type="text" name="comando" required><br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao" required></textarea><br><br>

        <label>Categoria:</label><br>
        <input type="text" name="categoria" required><br><br>

        <label>Exemplo de uso:</label><br>
        <input type="text" name="exemplo"><br><br>

        <button type="submit">Salvar</button>
    </form>

    <p><a href="dashboard.php">← Voltar para dashboard</a></p>
</body>
</html>