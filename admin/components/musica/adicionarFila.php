<?php
    require_once '../../../includes/config/auth.php';
    require_once '../../../includes/config/conexao.php';

    $conexao =(new Conexao())->conectar();

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $titulo = trim($_POST['titulo']);
        $autor = trim($_POST['autor']);
        $criado_por = $_SESSION['usuario_id'];

        //IDs DOS STATUS
        $statusAndamento = 1; // "Andamento"
        $statusEmEspera = 2; // "Em espera"
        
        // Verifica se já existe uma música em andamento para o usuário
        $sqlVerifica = "SELECT COUNT(*) FROM musica WHERE usuario_id = ? AND id_status = ?";
        $stmtVerifica = $conexao->prepare($sqlVerifica);
        $stmtVerifica->execute([$criado_por, $statusAndamento]);
        $existeEmAndamento = $stmtVerifica->fetchColumn();

        // Se já houver música em andamento, nova entra como "Em espera"
        $statusNovaMusica = $existeEmAndamento ? $statusEmEspera : $statusAndamento;

        // Insere a nova música
        $sqlInserir = "INSERT INTO musica (titulo, autor, usuario_id, id_status) VALUES (?, ?, ?, ?)";
        $stmtInserir = $conexao->prepare($sqlInserir);
        $stmtInserir->execute([$titulo, $autor, $criado_por, $statusNovaMusica]);

        header('Location: ../../pages/estatisticas.php');
    exit;
}
?>