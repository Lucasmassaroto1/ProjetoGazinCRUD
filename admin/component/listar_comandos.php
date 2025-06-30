<?php 
    require_once '../../config/conexao.php';
    require_once '../../config/auth.php';

    $conexao = (new Conexao())->conectar();

    $usuario_id = $_SESSION['usuario_id'];
    $usuario_tipo = $_SESSION['usuario_tipo'];

    // ================ PAGINAÇÃO ================
    $limite = 3;
    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $pagina = max(1, $pagina);
    $offset = ($pagina - 1) * $limite;

    // ================ CONSULTA COM FILTRO ================
    if($usuario_tipo === 'admin'){
        $stmt = $conexao->prepare("SELECT c.*, u.usuario AS autor FROM conteudo c JOIN usuarios u ON c.criado_por = u.id ORDER BY c.data_criacao DESC LIMIT :limite OFFSET :offset");

        $stmtTotal = $conexao->query("SELECT COUNT(*) AS total FROM conteudo");
    }else{
        $stmt = $conexao->prepare("SELECT c.*, u.usuario AS autor FROM conteudo c JOIN usuarios u ON c.criado_por = u.id WHERE c.criado_por = :usuario_id ORDER BY c.data_criacao DESC LIMIT :limite OFFSET :offset");

        $stmtTotal = $conexao->prepare("SELECT COUNT(*) AS total FROM conteudo WHERE criado_por = :usuario_id");
        $stmtTotal->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
    }

    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmtTotal->execute();
    $total = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPaginas = ceil($total / $limite);

    // ================ HTML ================
    ob_start();
    if(empty($dados)){
        echo "<p style='color: yellow;'>Nenhum comando encontrado.</p>";
    }
    foreach ($dados as $cmd): ?>
        <div class="activity-item" data-categoria="<?= strtolower(preg_replace('/\s+/', '', $cmd['categoria'])) ?>">
            <div class="activity-content">
                <p><strong>Comando:</strong> <?= htmlspecialchars($cmd['comando']) ?></p>
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