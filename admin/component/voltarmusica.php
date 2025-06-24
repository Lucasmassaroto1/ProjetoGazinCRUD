<?php
    require_once '../../config/conexao.php';
    session_start();
    $conexao = (new Conexao())->conectar();

    $usuario_id = $_SESSION['usuario_id'];

    // Verificar se existe alguma música com status andamento (1)
    $stmt = $conexao->prepare("SELECT * FROM musica WHERE usuario_id = ? AND id_status = 1 ORDER BY id ASC LIMIT 1");
    $stmt->execute([$usuario_id]);
    $musica_atual = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$musica_atual) {
        // ❗ Nenhuma música em andamento -> Resetar a fila
        
        // Buscar a música de menor ID (primeira da lista)
        $stmt = $conexao->prepare("SELECT * FROM musica WHERE usuario_id = ? ORDER BY id ASC LIMIT 1");
        $stmt->execute([$usuario_id]);
        $primeira_musica = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($primeira_musica) {
            // Definir a primeira música como andamento
            $stmt = $conexao->prepare("UPDATE musica SET id_status = 1 WHERE id = ?");
            $stmt->execute([$primeira_musica['id']]);

            // Definir todas as outras como espera
            $stmt = $conexao->prepare("UPDATE musica SET id_status = 2 WHERE usuario_id = ? AND id != ?");
            $stmt->execute([$usuario_id, $primeira_musica['id']]);
        }

        echo json_encode(['success' => true, 'reset' => true]);
        exit;
    }

    // Coloca a música atual em espera (id_status = 2)
    $stmt = $conexao->prepare("UPDATE musica SET id_status = 2 WHERE id = ?");
    $stmt->execute([$musica_atual['id']]);

    // Buscar a música anterior (id menor que a atual)
    $stmt = $conexao->prepare("
        SELECT * FROM musica 
        WHERE usuario_id = ? AND id < ? 
        ORDER BY id DESC LIMIT 1
    ");
    $stmt->execute([$usuario_id, $musica_atual['id']]);
    $musica_anterior = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($musica_anterior) {
        // Atualiza para andamento (id_status = 1) a música anterior
        $stmt = $conexao->prepare("UPDATE musica SET id_status = 1 WHERE id = ?");
        $stmt->execute([$musica_anterior['id']]);

        // Coloca todas as outras músicas como espera
        $stmt = $conexao->prepare("UPDATE musica SET id_status = 2 WHERE usuario_id = ? AND id != ?");
        $stmt->execute([$usuario_id, $musica_anterior['id']]);
    } else {
        // Se não há música anterior, volta para a atual
        $stmt = $conexao->prepare("UPDATE musica SET id_status = 1 WHERE id = ?");
        $stmt->execute([$musica_atual['id']]);
    }

    echo json_encode(['success' => true]);
?>
