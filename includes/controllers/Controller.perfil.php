<?php 
    require_once '../../../includes/config/auth.php';
    require_once '../../../includes/config/conexao.php';

    $conexao =(new Conexao())->conectar();

    $usuario_id = $_SESSION['usuario_id'];
    
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$usuario_id]);
    $user = $stmt->fetch();

    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $usuario_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $mensagem = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $novo_nome = trim($_POST['nome'] ?? '');
        $novo_email = trim($_POST['email'] ?? '');

        $campos = [];
        $valores = [];

        if(!empty($novo_nome) && $novo_nome != $user['usuario']){
            $campos[] = "usuario = ?";
            $valores[] = $novo_nome;
        }

        if(!empty($novo_email) && $novo_email != $user['email']){
            $campos[] = "email = ?";
            $valores[] = $novo_email;
        }

        if(count($campos) > 0){
            $valores[] = $usuario_id;
            $sql = "UPDATE usuarios SET ".implode(", ", $campos)." WHERE id = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->execute($valores);

            if(!empty($novo_nome)) $_SESSION['usuario_nome'] = $novo_nome;
            if(!empty($novo_email)) $_SESSION['usuario_email'] = $novo_email;

            $mensagem = "<p style='color:green'>Dados atualizados com sucesso!</p>";
            header("Refresh: 1");
        }else{
            $mensagem = "<p style='color:orange'>Nenhuma alteração detectada.</p>";
        }
    }

    // ================ TEMA DO SITE ================
    $tema = 'azul';
    if(isset($_SESSION['usuario_id'])){
        $stmt = $conexao->prepare("SELECT tema FROM usuarios WHERE id = ?");
        $stmt->execute([$_SESSION['usuario_id']]);
        $res = $stmt->fetch();
        if($res && in_array($res['tema'], ['azul', 'roxo', 'verde'])){
            $tema = $res['tema'];
        }
    }
?>