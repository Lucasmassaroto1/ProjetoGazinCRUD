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
    <title>Bytecrud - Editar Comandos</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="card-command">
                <div class="card">
                    <div class="card-header">
                        <h2>Editar Comando</h2>
                    </div>
                    <div class="card-body">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>