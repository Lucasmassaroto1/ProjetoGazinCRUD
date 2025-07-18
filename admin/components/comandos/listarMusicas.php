<?php 
    require_once '../../../includes/config/conexao.php';
    require_once '../../../includes/config/auth.php';

    $conexao = (new Conexao())->conectar();

    $usuario_id = $_SESSION['usuario_id'];
    $usuario_tipo = $_SESSION['usuario_tipo'];

    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $usuario_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // ================ PAGINAÇÃO ================
    $limite = 2;

    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $pagina = $pagina < 1 ? 1 : $pagina;

    $offset = ($pagina - 1) * $limite;

    $stmtmusic = $conexao->prepare("SELECT m.*, s.nome AS nome_status FROM musica m JOIN status s ON m.id_status = s.id WHERE usuario_id = ? ORDER BY m.id ASC, m.id_status ASC LIMIT ? OFFSET ?");

    $stmtmusic->bindValue(1, $usuario_id, PDO::PARAM_INT);
    $stmtmusic->bindValue(2, $limite, PDO::PARAM_INT);
    $stmtmusic->bindValue(3, $offset, PDO::PARAM_INT);
    $stmtmusic->execute();
    $musica = $stmtmusic->fetchAll(PDO::FETCH_ASSOC);

    $stmtTotal = $conexao->prepare("SELECT COUNT(*) AS total FROM musica WHERE usuario_id = ?");
    $stmtTotal->execute([$usuario_id]);
    $total = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

    $totalPaginas = ceil($total / $limite);

    
    // ================ HTML ================
    ob_start();
    if(empty($musica)){
        echo "<p style='color: yellow;'>Nenhuma música encontrado.</p>";
    }
    foreach ($musica as $mus): ?>
        <div class="activity-item">
            <div class="activity-content">
                <p><strong>Titulo:</strong> <span id="total-commands"><?= htmlspecialchars($mus['titulo']) ?></span></p>
                <p><strong>Autor:</strong> <span id="commands-today"><?= htmlspecialchars($mus['autor']) ?></span></p>
                <button onclick="if(confirm('Tem certeza que deseja excluir?')){window.location.href='../../components/musica/deleteMusica.php?id=<?= $mus['id'] ?>';}" type="button" class="btn btnhover"><i class="fas fa-trash-alt"></i></button>
            </div>
        </div>
    <?php endforeach;

    if($totalPaginas > 1): ?>
        <div class="paginacao">
            <?php if($pagina > 1): ?>
                <a class="btn" href="#" onclick="carregarMusicasPagina(<?= $pagina - 1 ?>); return false;">&laquo; Anterior</a>
            <?php endif; ?>
            <?php for($i = 1; $i <= $totalPaginas; $i++): ?>
                <a class="btn <?= ($i == $pagina) ? 'ativo' : '' ?>" href="#" onclick="carregarMusicasPagina(<?= $i ?>); return false;"><?= $i ?></a>
            <?php endfor; ?>
            <?php if($pagina < $totalPaginas): ?>
                <a class="btn" href="#" onclick="carregarMusicasPagina(<?= $pagina + 1 ?>); return false;">Próximo &raquo;</a>
            <?php endif; ?>
        </div>
    <?php endif;

    echo ob_get_clean();
?>