<?php 
    require_once '../../../config/auth.php';
    require_once '../../../config/conexao.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        $comando = $_POST['comando'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $categoria = $_POST['categoria'] ?? '';
        $exemplo = $_POST['exemplo'] ?? '';

        // Validação básica (você pode ampliar)
        if ($id && $comando && $descricao && $categoria && $exemplo) {
            $conexao = (new Conexao())->conectar();

            $sql = "UPDATE conteudo SET comando = :comando, descricao = :descricao, categoria = :categoria, exemplo = :exemplo WHERE id = :id";
            $stmt = $conexao->prepare($sql);

            $stmt->bindParam(':comando', $comando);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':exemplo', $exemplo);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Atualizado com sucesso, redirecionar para a página de comandos
                header('Location: ../../pages/painel/comandos.php');
                exit;
            } else {
                echo "Erro ao atualizar o comando.";
            }
        } else {
            echo "Dados incompletos.";
        }
    } else {
        echo "Método inválido.";
    }
?>