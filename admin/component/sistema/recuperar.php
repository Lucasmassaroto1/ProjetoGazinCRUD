<?php 
    require_once '../../../config/conexao.php';

    require '../bibliotecas/PHPMailer/Exception.php';
    require '../bibliotecas/PHPMailer/PHPMailer.php';
    require '../bibliotecas/PHPMailer/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $conexao =(new Conexao())->conectar();

    $mensagem = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $usuario_ou_email = $_POST['usuario'] ?? '';

        // Consulta aceitando usuário ou e-mail
        $sql = "SELECT * FROM usuarios WHERE usuario = ? OR email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$usuario_ou_email, $usuario_ou_email]);
        $user = $stmt->fetch();

        if($user){
            $token = bin2hex(random_bytes(50));
            $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $sql = "UPDATE usuarios SET token_recuperacao = ?, token_expiracao = ? WHERE id = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->execute([$token, $expira, $user['id']]);

            $link = "http://localhost/ProjetoGazinCRUD/admin/pages/auth/redefinir.php?token=$token";

            // Envia e-mail
            $mail = new PHPMailer(true);

            try{
                // Configurações do servidor SMTP
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'lucasmassaroto17@gmail.com';   // bytecode.massaroto@gmail.com
                $mail->Password   = '';          // Senha de app do Gmail (https://myaccount.google.com/apppasswords?rapt=AEjHL4OA7WatJy9vrmx3aICkZJGSYbCK3UnPa6oCJI8Lm0jQNgRuK6Rqa59jO5cH9tbFPsKORrOerNwVSQV3QUFKHUAbG9shN1rIG_l7TdAf8AqIlU6R_pE)
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
                $mail->Body = "
                <div style='font-family: Arial, sans-serif; color: #333; background-color: #f9f9f9; padding: 30px; border-radius: 8px; max-width: 600px; margin: auto; border: 1px solid #ddd;'>
                    <h2 style='color: #4CAF50;'>Olá {$user['usuario']},</h2>

                    <p style='font-size: 16px; line-height: 1.6;'>
                        Recebemos uma solicitação para redefinir sua senha.
                    </p>

                    <p style='font-size: 16px; line-height: 1.6;'>
                        Clique no botão abaixo para criar uma nova senha:
                    </p>

                    <p style='text-align: center; margin: 30px 0;'>
                        <a href='$link' style='background-color: #4CAF50; color: white; padding: 12px 20px; text-decoration: none; font-weight: bold; border-radius: 5px; display: inline-block;'>
                            Redefinir Senha
                        </a>
                    </p>

                    <hr style='border: none; border-top: 1px solid #ddd; margin: 40px 0;'>

                    <p style='font-size: 14px; color: #999;'>
                        Se você não solicitou a alteração de senha, pode ignorar este e-mail.
                    </p>

                    <p style='font-size: 14px; color: #999;'>
                        Atenciosamente,<br>
                        <strong>Equipe ByteCode</strong>
                    </p>
                </div>";

                $mail->send();
                $mensagem = "<p style='color:green'>Um link de recuperação foi enviado para seu e-mail!</p>";
            }catch (Exception $e){
                $mensagem = "<p style='color:red'>Erro ao enviar o e-mail: {$mail->ErrorInfo}</p>";
            }
        }else{
            $mensagem = "<p style='color:red'>Usuário ou e-mail não encontrado.</p>";
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
    <title>Bytecrud - Recuperar Senha</title>
</head>
<body>
    <?php $base_url = '../../../';?>
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
                            <input type="text" name="usuario" class="inputwelcome" placeholder="Usuário ou E-mail" required><br><br>
                            <button type="submit" class="btn btnhover">Enviar Link</button>
                            <a href="../../pages/auth/login.php">Voltar login</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>