<?php 
    session_start();
    require_once '../config/conexao.php';
    $conexao =(new Conexao())->conectar();
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $usuario = $_POST['usuario'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $sql = "select * from usuarios where usuario = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$usuario]);
        $user = $stmt->fetch();

        if ($user && hash('sha256', $senha) === $user['senha']) {
        $_SESSION['usuario'] = $usuario;
        header('Location: dashboard.php');
        exit;
        } else {
            $erro = "Usuário ou senha inválidos!";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bytecrud</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($erro)): ?>
        <p style="color:red"><?= $erro ?></p>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="usuario" placeholder="Usuário" required><br><br>
        <input type="password" name="senha" placeholder="Senha" required><br><br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>