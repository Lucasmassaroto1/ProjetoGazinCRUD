<?php 
    require_once '../config/conexao.php';
    $conexao =(new Conexao())->conectar();

    $prefixo = $_POST['prefixo'] ?? null;

    if($prefixo && strlen($prefixo) === 1){
        //======= VERIFICA SE JÁ EXISTE PREFIXOS =======
        $sql = 'SELECT id FROM prefixos LIMIT 1';
        $result = $conexao->query($sql)->fetch();

        if($result){
            //======= ATUALIZA =======
            $stmt = $conexao->prepare("UPDATE prefixos SET prefixo_customizado = :prefixo, criado_em = CURRENT_TIMESTAMP WHERE id = :id");
            $stmt->bindValue(':prefixo', $prefixo);
            $stmt->bindValue(':id', $result['id']);
            $stmt->execute();
        }else{
            //======= INSERE =======
            $stmt = $conexao->prepare("INSERT INTO prefixos (prefixo_customizado) VALUES (:prefixo)");
            $stmt->bindValue(':prefixo', $prefixo);
            $stmt->execute();
        }
    }
    header('Location: pages/comandos.php');
    exit;
?>