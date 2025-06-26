<?php 
    require_once '../../config/conexao.php';

    $conexao =(new Conexao())->conectar();

    // ================ CONTEUDO (COMANDOS) ================
    $limite = 3;
    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $pagina = $pagina < 1 ? 1 : $pagina;
    $offset = ($pagina - 1) * $limite;

    $stmt = $conexao->prepare("SELECT c.*, u.usuario AS autor FROM conteudo c JOIN usuarios u ON c.criado_por = u.id ORDER BY c.data_criacao DESC LIMIT :limite OFFSET :offset");
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmtTotal = $conexao->query("SELECT COUNT(*) AS total FROM conteudo");
    $total = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPaginas = ceil($total / $limite);
    $total_commands = $total;

    // Retorna apenas o conteúdo da lista
    ob_start();
    foreach ($dados as $cmd): ?>
        <div class="activity-item" data-categoria="<?= strtolower(preg_replace('/\s+/', '', $cmd['categoria'])) ?>">
            <div class="activity-content">
                <div id="exibicao-<?= $cmd['id'] ?>">
                    <p><strong>Comando:</strong> <?= htmlspecialchars($cmd['comando']) ?></p>
                    <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($cmd['descricao'])) ?></p>
                    <p><strong>Categoria:</strong> <?= htmlspecialchars($cmd['categoria']) ?></p>
                    <p><strong>Exemplo:</strong> <?= htmlspecialchars($cmd['exemplo']) ?></p>
                    <p><strong>Criado por:</strong> <?= htmlspecialchars($cmd['autor']) ?></p>
                </div>
            </div>
        </div>
    <?php endforeach;

    if($totalPaginas > 1): ?>
        <div class="paginacao">
            <?php if($pagina > 1): ?>
                <a class="btn" href="#" onclick="carregarPagina(<?= $pagina - 1 ?>); return false;">&laquo; Anterior</a>
            <?php endif; ?>

            <?php for($i = 1; $i <= $totalPaginas; $i++): ?>
                <a class="btn <?= ($i == $pagina) ? 'ativo' : '' ?>" href="#" onclick="carregarPagina(<?= $i ?>); return false;"><?= $i ?></a>
            <?php endfor; ?>

            <?php if($pagina < $totalPaginas): ?>
                <a class="btn" href="#" onclick="carregarPagina(<?= $pagina + 1 ?>); return false;">Próximo &raquo;</a>
            <?php endif; ?>
        </div>
    <?php endif;

    echo ob_get_clean();
?>