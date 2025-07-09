<?php 
    require_once '../config/auth.php';
    require_once '../config/conexao.php';
    $conexao = (new Conexao())->conectar();

    $mensagem = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $usuario = $_POST['usuario'] ?? '';
        $senha_atual = $_POST['senha_atual'] ?? '';
        $nova_senha = $_POST['nova_senha'] ?? '';
        $confirma_senha = $_POST['confirma_senha'] ?? '';
        
        $usuario_id = $_SESSION['usuario_id'];
        /* $sql = "SELECT * FROM usuarios WHERE usuario = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$usuario]);
        $user = $stmt->fetch(); */

        $sql = "SELECT senha FROM usuarios WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$usuario_id]);
        $user = $stmt->fetch();

        if($user){
            // Verifica se senha atual bate com o hash
            if(password_verify($senha_atual, $user['senha'])){
                if($nova_senha === $confirma_senha){
                    $novaSenhaHash = password_hash($nova_senha, PASSWORD_DEFAULT);
                    $update = "UPDATE usuarios SET senha = ? WHERE usuario = ?";
                    $stmt = $conexao->prepare($update);
                    $stmt->execute([$novaSenhaHash, $usuario]);

                    $mensagem = "<p style='color:green'>Senha alterada com sucesso!</p>";
                }else{
                    $mensagem = "<p style='color:red'>As senhas não coincidem.</p>";
                }
            }else{
                $mensagem = "<p style='color:red'>Senha atual incorreta.</p>";
            }
        }else{
            $mensagem = "<p style='color:red'>Usuário não encontrado.</p>";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../public/img/Favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/assets/style/pages/login.css">
    <title>Bytecrud - Trocar Senha</title>
</head>
<body>
    <?php $base_url = '../../';?>
    <div class="container">
        <div class="row">
            <div class="card-login">
                <div class="card">
                    <div class="card-header">
                        <h2>Alterar senha</h2>
                    </div>
                    <div class="card-body">
                        <?= $mensagem ?? '' ?>
                        <form method="post">
                            <input type="password" name="senha_atual" placeholder="Senha atual" required><br><br>
                            <input type="password" name="nova_senha" placeholder="Senha nova" required><br><br>
                            <input type="password" name="confirma_senha" placeholder="Confirmar senha" required><br><br>
                            <button type="submit" class="btn btnhover">Salvar Senha</button>
                            <a href="pages/perfil.php" class="btn btn-link">Voltar para Perfil</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>