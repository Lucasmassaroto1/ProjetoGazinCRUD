<?php 
    require_once '../../../includes/config/auth.php';
    require_once '../../../includes/config/conexao.php';

    $conexao =(new Conexao())->conectar();
    $usuario_id = $_SESSION['usuario_id'];

    try{
        // Deleta todos os conteúdos criados pelo usuário
        $sqlConteudo = "DELETE FROM conteudo WHERE criado_por = ?";
        $stmtConteudo = $conexao->prepare($sqlConteudo);
        $stmtConteudo->execute([$usuario_id]);

        //Deleta usuario logado
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$usuario_id]);

        //Destruir sessão
        session_destroy();

        //Manda para login
        header('Location: ../../../../views/auth/login.php');
        exit;
    }catch(PDOException $e){
        echo 'Erro ao deletar conta'. $e->getMessage();
    }
?>