<?php 
    require_once '../../config/conexao.php';

    require 'bibliotecas/PHPMailer/Exception.php';
    require 'bibliotecas/PHPMailer/PHPMailer.php';
    require 'bibliotecas/PHPMailer/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $conexao =(new Conexao())->conectar();

    $mensagem = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario_ou_email = $_POST['usuario'] ?? '';

        // Consulta aceitando usuário ou e-mail
        $sql = "SELECT * FROM usuarios WHERE usuario = ? OR email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$usuario_ou_email, $usuario_ou_email]);
        $user = $stmt->fetch();

        if ($user) {
            $token = bin2hex(random_bytes(50));
            $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $sql = "UPDATE usuarios SET token_recuperacao = ?, token_expiracao = ? WHERE id = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->execute([$token, $expira, $user['id']]);

            $link = "http://localhost/ProjetoGazinCRUD/admin/redefinir.php?token=$token";

            // Envia e-mail
            $mail = new PHPMailer(true);

            try {
                // Configurações do servidor SMTP
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'lucasmassaroto17@gmail.com';   // Seu e-mail
                $mail->Password   = '';          // Senha de app do Gmail
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;
                $mail->CharSet = 'UTF-8';
                // Remetente
                $mail->setFrom('lucasmassaroto17@gmail.com', 'ByteCode');

                // Destinatário
                $mail->addAddress($user['email'], $user['usuario']);

                // Conteúdo do e-mail
                $mail->isHTML(true);
                $mail->Subject = 'Recuperação de Senha - ByteCRUD';
                $mail->Body    = "Olá {$user['usuario']}.<br><br> Recebemos uma solicitação para redefinir sua senha.<br><br> Clique no link abaixo para criar uma nova senha: <a href='$link'>$link</a><br><br> Se não foi você que solicitou, apenas ignore este e-mail.<br><br> Atenciosamente, <br> Equipe ByteCode.";

                $mail->send();
                $mensagem = "<p style='color:green'>Um link de recuperação foi enviado para seu e-mail!</p>";
            } catch (Exception $e){
                $mensagem = "<p style='color:red'>Erro ao enviar o e-mail: {$mail->ErrorInfo}</p>";
            }

        }else{
            $mensagem = "<p style='color:red'>Usuário ou e-mail não encontrado.</p>";
        }
    }
    /* if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = $_POST['email'] ?? '';

        // Verifica se o usuário existe
        $sql = "SELECT * FROM usuarios WHERE usuario = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if($user){
            // Gera token único
            $token = bin2hex(random_bytes(50));
            $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Salva no banco
            $sql = "UPDATE usuarios SET token_recuperacao = ?, token_expiracao = ? WHERE usuario = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->execute([$token, $expira, $email]);

            // Monta link
            $link = "http://localhost/ProjetoGazinCRUD/admin/redefinir.php?token=$token";

            // Simula envio de e-mail (para produção, use PHPMailer)
            // mail($user['email'], "Recuperação de Senha", "Clique aqui para redefinir sua senha: $link");

            // Exibe mensagem simulada
            $mensagem = "<p style='color:green'>Um link de recuperação foi enviado para seu e-mail. (Link: <a href='$link'>$link</a>)</p>";
        }else{
            $mensagem = "<p style='color:red'>Usuário não encontrado.</p>";
        }
    } */
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../public/img/Favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/assets/style/login.css">
    <title>Bytecrud - Recuperar Senha</title>
</head>
<body>
    <?php $base_url = '../../';?>
    <div class="container">
        <div class="row">
            <div class="card-login">
                <div class="card">
                    <div class="card-header">
                        <h2>Recuperar senha</h2>
                    </div>
                    <div class="card-body">
                        <?= $mensagem ?? '' ?>
                        <form method="post">
                            <input type="text" name="usuario" placeholder="Usuário ou E-mail" required><br><br>
                            <button type="submit" class="btn">Enviar Link</button>
                            <a href="../login.php">Voltar login</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>