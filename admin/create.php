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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Um simples DashBoard para configurar o ByteCode">
    <meta name="author" content="Lucas Massaroto">
    <!-- ======== FAVICON ======== -->
    <link rel="shortcut icon" href="../public/img/Favicon/favicon.ico" type="image/x-icon">
    <!-- ======== FONT & ICONS ======== -->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- ======== ESTILO & RESPONSIVIDADE ======== -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="src/style/create.css">
    <title>Bytecrud - Adicionar Comando</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="card-command">
                <div class="card">
                    <div class="card-header">
                        <h2>Adicionar Novo Comando</h2>
                    </div>
                    <div class="card-body">
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
                            <p><a href="dashboard.php">← Voltar para dashboard</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>