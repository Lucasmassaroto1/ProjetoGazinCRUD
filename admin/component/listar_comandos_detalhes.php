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
    $categoriaFiltro = isset($_GET['categoria']) ? trim($_GET['categoria']) : '';

    $queryBase = "SELECT c.*, u.usuario AS autor FROM conteudo c JOIN usuarios u ON c.criado_por = u.id";
    $condicoes = [];
    $params = [];

    if($usuario_tipo !== 'admin'){
        $condicoes[] = "c.criado_por = :usuario_id";
        $params[':usuario_id'] = $usuario_id;
    }
    if(!empty($categoriaFiltro)){
        $condicoes[] = "LOWER(TRIM(SUBSTRING_INDEX(c.categoria, '-', -1))) = :categoria";
        $params[':categoria'] = strtolower($categoriaFiltro);
    }
    /* if(!empty($categoriaFiltro)){
        $condicoes[] = "LOWER(REPLACE(c.categoria, ' ', '')) = :categoria";
        $params[':categoria'] = strtolower($categoriaFiltro);
    } */
    if(!empty($condicoes)){
        $queryBase .= " WHERE " . implode(" AND ", $condicoes);
    }
    $queryBase .= " ORDER BY c.data_criacao DESC LIMIT :limite OFFSET :offset";
    $stmt = $conexao->prepare($queryBase);
    foreach($params as $chave => $valor){
        $stmt->bindValue($chave, $valor);
    }
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Total para paginação
    $queryCount = "SELECT COUNT(*) AS total FROM conteudo c";
    if (!empty($condicoes)) {
        $queryCount .= " JOIN usuarios u ON c.criado_por = u.id WHERE " . implode(" AND ", $condicoes);
    } else {
        $queryCount .= " JOIN usuarios u ON c.criado_por = u.id";
    }

    $stmtTotal = $conexao->prepare($queryCount);
    foreach ($params as $chave => $valor) {
        $stmtTotal->bindValue($chave, $valor);
    }
    $stmtTotal->execute();
    $total = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPaginas = ceil($total / $limite);
    $total_commands = $total; 
    
    // ================ HTML ================
    ob_start();
    if(empty($dados)){
        echo "<p style='color: yellow;'>Nenhum comando encontrado.</p>";
    }
    foreach ($dados as $cmd): ?>
        <?php
            $partes = explode('-', $cmd['categoria'], 2);
            $sufixoData = isset($partes[1]) ? strtolower(trim($partes[1])) : strtolower(trim($cmd['categoria']));
        ?>
        <div class="activity-item" data-categoria="<?= $sufixoData ?>">
            <div class="activity-content">
                <div id="exibicao-<?= $cmd['id'] ?>">
                    <p><strong>Comando:</strong> <span><?= htmlspecialchars($cmd['comando']) ?></span></p>
                    <p><strong>Descrição:</strong> <span><?= nl2br(htmlspecialchars($cmd['descricao'])) ?></span></p>
                    <p><strong>Categoria:</strong> <span><?= htmlspecialchars($sufixoData) ?></span></p>
                    <p><strong>Exemplo:</strong> <span><?= htmlspecialchars($cmd['exemplo']) ?></span></p>
                    <p><strong>Criado por:</strong> <span><?= htmlspecialchars($cmd['autor']) ?></span></p>
                    <p class="atalho">
                        <a href=".../component/edit.php?id=<?= $cmd['id'] ?>" onclick="mostrarFormulario(<?= $cmd['id'] ?>); return false;"><i class="fas fa-pen"></i></a>
                        <a href="../component/delete.php?id=<?= $cmd['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')"><i class="fas fa-trash"></i></a>
                    </p>
                </div>
                <form id="form-<?= $cmd['id'] ?>" action="../component/edit.php" method="post" style="display: none;">
                    <input type="hidden" name="id" value="<?= $cmd['id'] ?>">
                    <input type="text" name="comando" class="inputwelcome" placeholder="Comando" value="<?= htmlspecialchars($cmd['comando']) ?>"><br><br>
                    <input type="text" name="descricao" class="inputwelcome" placeholder="Descrição" value="<?= htmlspecialchars($cmd['descricao']) ?>"><br><br>
                    <input type="text" name="categoria" class="inputwelcome" placeholder="Categoria" value="<?= htmlspecialchars($cmd['categoria']) ?>"><br><br>
                    <input type="text" name="exemplo" class="inputwelcome" placeholder="Exemplo de uso" value="<?= htmlspecialchars($cmd['exemplo']) ?>"><br><br>
                    <button type="submit" class="btn btnhover"><i class="fas fa-floppy-disk"></i> Salvar</button>
                    <button type="button" onclick="cancelarFormulario(<?= $cmd['id'] ?>)" class="btn btn-danger"><i class="fas fa-xmark"></i> Cancelar</button>
                </form>
            </div>
        </div>
    <?php endforeach;

    if($totalPaginas > 1): ?>
        <div class="paginacao">
            <?php if($pagina > 1): ?>
                <a class="btn" href="#" onclick="carregarPagina(<?= $pagina - 1 ?>, '<?= $categoriaFiltro ?>'); return false;">&laquo; Anterior</a>
            <?php endif; ?>
            <?php for($i = 1; $i <= $totalPaginas; $i++): ?>
                <a class="btn <?= ($i == $pagina) ? 'ativo' : '' ?>" href="#" onclick="carregarPagina(<?= $i ?>, '<?= $categoriaFiltro ?>'); return false;"><?= $i ?></a>
            <?php endfor; ?>
            <?php if($pagina < $totalPaginas): ?>
                <a class="btn" href="#" onclick="carregarPagina(<?= $pagina + 1 ?>, '<?= $categoriaFiltro ?>'); return false;">Próximo &raquo;</a>
            <?php endif; ?>
        </div>
    <?php endif;

    echo ob_get_clean();
?>