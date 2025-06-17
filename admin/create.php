<?php 
    require_once '../config/auth.php';
    require_once '../config/conexao.php';

    $conexao =(new Conexao())->conectar();

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $comando = $_POST['comando'];
        $descricao = $_POST['descricao'];
        $categoria = $_POST['categoria'];
        $exemplo = $_POST['exemplo'];
        $criado_por = $_SESSION['usuario_id'];

        $sql = "INSERT INTO conteudo (comando, descricao, categoria, exemplo, criado_por) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$comando, $descricao, $categoria, $exemplo, $criado_por]);

        header('Location: pages/comandos.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Um simples DashBoard para configurar o ByteCode">
    <meta name="author" content="Lucas Massaroto">
    <link rel="shortcut icon" href="../public/img/Favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/src/style/login.css">
    <title>Bytecrud - Adicionar Comando</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="card-login">
                <div class="card">
                    <div class="card-header">
                        <h2>Adicionar Novo Comando</h2>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <input type="text" name="comando" placeholder="Comando" required><br><br>
                            <input type="text" name="descricao" placeholder="Descrição" required><br><br>
                            <input type="text" name="categoria" placeholder="Categoria" required><br><br>
                            <input type="text" name="exemplo" placeholder="Exemplo de uso"><br><br>
                            <button type="submit" class="btn">Salvar</button>
                            <p><a href="pages/comandos.php">← Voltar para dashboard</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>