<?php
    require_once '../../../includes/config/conexao.php';
    $conexao = (new Conexao())->conectar();

    $mensagem = '';
    $token = $_GET['token'] ?? '';

    if($token){
        // Verifica se o token é válido
        $sql = "SELECT * FROM usuarios WHERE token_recuperacao = ? AND token_expiracao >= NOW()";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$token]);
        $user = $stmt->fetch();

        if($user){
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $nova_senha = $_POST['nova_senha'] ?? '';
                $confirma_senha = $_POST['confirma_senha'] ?? '';

                if($nova_senha === $confirma_senha){
                    $novaSenhaHash = password_hash($nova_senha, PASSWORD_DEFAULT);

                    // Atualiza senha e limpa o token
                    $sql = "UPDATE usuarios SET senha = ?, token_recuperacao = NULL, token_expiracao = NULL WHERE id = ?";
                    $stmt = $conexao->prepare($sql);
                    $stmt->execute([$novaSenhaHash, $user['id']]);

                    $mensagem = "<p style='color:green'>Senha alterada com sucesso! <a href='login.php'>Fazer login</a></p>";
                }else{
                    $mensagem = "<p style='color:red'>As senhas não coincidem.</p>";
                }
            }
        }else{
            $mensagem = "<p style='color:red'>Link inválido ou expirado.</p>";
        }
    }else{
        $mensagem = "<p style='color:red'>Token inválido.</p>";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../public/img/Favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../public/assets/style/base/base.css">
    <link rel="stylesheet" href="../../../public/assets/style/themes/temas.css">
    <link rel="stylesheet" href="../../../public/assets/style/views/login.css">
    <link rel="stylesheet" href="../../../public/assets/style/components/input.css">
    <title>Bytecrud - Redefinir Senha</title>
</head>
<body>
    <?php $base_url = '../../';?>
    <div class="container">
        <div class="row">
            <div class="card-login">
                <div class="card">
                    <div class="card-header">
                        <h2>Redefinir senha</h2>
                    </div>
                    <div class="card-body">
                        <?= $mensagem ?? '' ?>
                        <?php if(isset($user)): ?>
                            <p style="font-weight:bold; font-size: 1.3rem;"><?= htmlspecialchars($user['usuario']) ?></p>
                        <?php endif; ?>
                        <form method="post">
                            <input type="password" name="nova_senha" class="inputwelcome" placeholder="Senha nova" required><br><br>
                            <input type="password" name="confirma_senha" class="inputwelcome" placeholder="Confirmar senha" required><br><br>
                            <button type="submit" class="btn btnhover">Redefinir Senha</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>