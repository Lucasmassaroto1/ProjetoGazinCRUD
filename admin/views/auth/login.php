<?php 
    require_once '../../../includes/config/conexao.php';
    $conexao = (new Conexao())->conectar();

    session_start();
    $erro = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $usuario = $_POST['usuario'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $sql = "SELECT * FROM usuarios WHERE usuario = ? OR email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$usuario, $usuario]);
        $user = $stmt->fetch();

        if($user && password_verify($senha, $user['senha'])){
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nome'] = $user['usuario'];
            $_SESSION['usuario_tipo'] = $user['tipo'];

            header('Location: ../../views/painel/dashboard.php');
            exit;
        }else{
            $erro = "Usuário ou senha inválidos!";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../public/img/Favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../public/assets/style/pages/login.css">
    <link rel="stylesheet" href="../../../public/assets/style/input.css">
    <title>Bytecrud - Login</title>
</head>
<body>
    <?php $base_url = '../../../';?>
    <div class="container">
        <div class="row">
            <div class="card-login">
                <div class="card">
                    <div class="card-header">
                        <h2>Login</h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($erro)): ?>
                        <p style="color:red"><?= $erro ?></p>
                        <?php endif; ?>
                        <form method="post">
                            <input type="text" name="usuario" class="inputwelcome" placeholder="Usuário ou E-mail" required><br><br>
                            <input type="password" name="senha" class="inputwelcome" placeholder="Senha" required><br><br>
                            <button type="submit" class="btn btnhover">Entrar</button><br>
                            <a href="../../components/sistema/recuperar.php" class="btn btn-link">Esqueci a senha</a>
                            <a href="cadastro.php" class="btn btn-link">Criar nova conta</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>