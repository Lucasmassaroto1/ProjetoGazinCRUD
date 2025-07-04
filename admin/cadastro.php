<?php
require_once '../config/conexao.php';
$conexao = (new Conexao())->conectar();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $usuario = trim($_POST['usuario'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if(!empty($usuario) && !empty($email) && !empty($senha)){
        // Verificar se usuário ou email já existem
        $sql = "SELECT * FROM usuarios WHERE usuario = ? OR email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$usuario, $email]);

        if($stmt->fetch()){
            $erro = "Usuário ou e-mail já cadastrados!";
        }else{
            // Criptografar senha
            $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

            // Inserir no banco
            $sql = "INSERT INTO usuarios (usuario, email, senha) VALUES (?, ?, ?)";
            $stmt = $conexao->prepare($sql);
            $stmt->execute([$usuario, $email, $senhaCriptografada]);

            // Pega ID do usuário recém-cadastrado
            $usuario_id = $conexao->lastInsertId();

            session_start();
            $_SESSION['usuario_id'] = $usuario_id;
            $_SESSION['usuario_nome'] = $usuario;

            header('Location: login.php');
            exit;
        }
    }else{
        $erro = "Preencha todos os campos.";
    }
}

/* 
----------------------------------------------------------------------------
------------------------------ VERSÃO USANDO HASH --------------------------
---------------------------------------------------------------------------- 
*/
/* 
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if(!empty($usuario) && !empty($senha)){
        $sql = "SELECT * FROM usuarios WHERE usuario = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$usuario]);

        if($stmt->fetch()){
            $erro = "Usuário já existe!";
        }else{
            $senhaCriptografada = hash('sha256', $senha);
            $sql = "INSERT INTO usuarios (usuario, senha) VALUES (?, ?)";
            $stmt = $conexao->prepare($sql);
            $stmt->execute([$usuario, $senhaCriptografada]);

            $usuario_id = $conexao->lastInsertId();

            session_start();
            $_SESSION['usuario_id'] = $usuario_id;
            $_SESSION['usuario_nome'] = $usuario;
            $_SESSION['usuario_tipo'] = $user['tipo'];

            header('Location: login.php');
            exit;
        }
    }else{
        $erro = "Preencha todos os campos.";
    }
} */
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../public/img/Favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/assets/style/login.css">
    <title>Bytecrud - Novo usuario</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="card-login">
                <div class="card">
                    <div class="card-header">
                        <h2 class="mt-5">Cadastro de Usuário</h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($erro)): ?>
                            <p style="color: red;"><?= $erro ?></p>
                        <?php endif; ?>
                        <form method="post">
                            <input type="text" name="usuario" placeholder="Usuário" required>
                            <input type="email" name="email" placeholder="E-mail" required>
                            <input type="password" name="senha" placeholder="Senha" required>
                            <button type="submit" class="btn ">Cadastrar</button>
                            <a href="login.php" class="btn">Já tem conta? Fazer login</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>