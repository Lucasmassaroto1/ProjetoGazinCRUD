<?php
    require_once '../../config/conexao.php';
    session_start();
    $conexao = (new Conexao())->conectar();

    $usuario_id = $_SESSION['usuario_id'];

    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Atualiza nome e email
    $query = "UPDATE usuarios SET usuario = :nome, email = :email WHERE id = :id";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $usuario_id);
    $stmt->execute();

    // Excluir a foto
    if(isset($_POST['remover_foto'])){
        // Busca nome da foto atual
        $stmt = $conexao->prepare("SELECT foto_perfil FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $usuario_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!empty($user['foto_perfil'])){
            $caminho_foto = "../../public/uploads/".$user['foto_perfil'];

            // Remove o arquivo do servidor
            if(file_exists($caminho_foto)){
                unlink($caminho_foto);
            }

            // Remove o nome do campo no banco
            $stmt = $conexao->prepare("UPDATE usuarios SET foto_perfil = NULL WHERE id = :id");
            $stmt->bindParam(':id', $usuario_id);
            $stmt->execute();
        }
        header('Location: ../pages/perfil.php');
        exit;
    }
    
    /* // Foto Sem Corte
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
        $foto = $_FILES['foto'];
        $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
        $nome_arquivo = uniqid() . "." . $ext;
        $caminho = "../../public/uploads/" . $nome_arquivo;

        // Move o arquivo
        if(move_uploaded_file($foto['tmp_name'], $caminho)){
            // Atualiza no banco
            $stmt = $conexao->prepare("UPDATE usuarios SET foto_perfil = :foto WHERE id = :id");
            $stmt->bindParam(':foto', $nome_arquivo);
            $stmt->bindParam(':id', $usuario_id);
            $stmt->execute();
        }
    } */

    // Foto Com Corte Usando O Cropper.js
    if(!empty($_POST['cropped_image'])){
        $data = $_POST['cropped_image'];

        // Separa os metadados do base64
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);

        // Gera nome e salva imagem
        $nome_arquivo = uniqid() . '.png';
        $caminho = "../../public/uploads/" . $nome_arquivo;
        file_put_contents($caminho, $data);

        // Atualiza no banco
        $stmt = $conexao->prepare("UPDATE usuarios SET foto_perfil = :foto WHERE id = :id");
        $stmt->bindParam(':foto', $nome_arquivo);
        $stmt->bindParam(':id', $usuario_id);
        $stmt->execute();
    }

    // Atualiza a sessão
    $_SESSION['usuario_nome'] = $nome;

    // Redireciona
    header("Location: ../pages/perfil.php");
    exit;
?>
