<?php 
    require_once '../../config/auth.php';
    require_once '../../config/conexao.php';

    $conexao =(new Conexao())->conectar();
    $usuario_id = $_SESSION['usuario_id'];

    try{
        //Deleta usuario logado
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$usuario_id]);

        //Destruir sessão
        session_destroy();

        //Manda para login
        header('Location: ../login.php');
        exit;
    }catch(PDOException $e){
        echo 'Erro ao deletar conta'. $e->getMessage();
    }
?>