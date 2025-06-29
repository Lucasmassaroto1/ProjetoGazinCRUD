<link rel="stylesheet" href="<?=$base_url?>public/assets/style/filtro.css">
<link rel="stylesheet" href="<?=$base_url?>public/assets/style/cards.css">
<link rel="stylesheet" href="<?=$base_url?>public/assets/style/embed.css">

<div class="grid-cards">
    <div class="card-status">
        <div class="card-header">
            <i class="fas fa-terminal"></i>
            <h2>Comandos Personalizados</h2>
        </div>
        <div class="card-body">
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-content">
                        <?php if ($conteudos): ?>
                            <?php foreach ($conteudos as $cmd): ?>
                                <p><strong>Comando:</strong> <span id="total-commands"><?= htmlspecialchars($cmd['comando']) ?></span></p>
                                <?php endforeach; ?>
                                    <button onclick="window.location.href='../create.php'" type="button" class="btn btnhover"><i class="fa-solid fa-plus"></i> Novo Comando</button>
                        <?php else: ?>
                            <p>Crie um comando personalizado Aqui.</p>
                            <button onclick="window.location.href='../create.php'" type="button" class="btn btnhover">+ Novo Comando</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid-cards">
        <div class="card-status">
            <div class="card-header">
                <i class="fas fa-robot"></i>
                <h2>Prefixo</h2>
            </div>
            <div class="card-body">
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-content">
                            <form action="../component/valida_prefix.php" method="post">
                                <p><strong>Prefixo Original:</strong> <span id="original-prefix" class="status-prefix">!</span></p>
                                <p><strong>Prefixo Personalizado:</strong> <span id="custom-prefix" class="status-prefix"><?= htmlspecialchars($prefixo_atual ?? '-') ?></span></p>
                                <p><input type="text" name="prefixo" id="input-prefix" class="inputwelcome" placeholder="Digite o prefixo" maxlength="1"></p>
                                <button type="submit" class="btn btnhover">Salvar Prefixo</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php if ($welcomeInputs): ?>
    <div class="grid-cards">
        <div class="card-status">
            <div class="card-header">
                <i class="fas fa-users"></i>
                <h2>Welcome</h2>
            </div>
            <div class="card-body">
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-content">
                            <form action="../component/valida_welcome.php" method="post">
                                <input type="text" name="titulo" class="inputwelcome" placeholder="Titulo" value="<?= $welcomeInputs['titulo'] ?? ''?>" required><br>
                                <input type="text" name="mensagem" class="inputwelcome"  placeholder="Mensagem" value="<?= $welcomeInputs['mensagem'] ?? ''?>" required>
                                <label style="color: var(--marcador-color);">Use: {user.mention} para marcar pelo cargo</label>
                                <input type="text" name="footer" class="inputwelcome"  placeholder="footer" value="<?= $welcomeInputs['footer'] ?? ''?>" required><br>
                                <button type="submit" class="btn btnhover"> Salvar Mensagem</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>

<div class="card-status activity-log">
    <div class="card-header">
        <i class="fas fa-terminal"></i>
        <h2> Detalhes Comandos Personalizados</h2>
    </div>
    <div class="card-body">
        <div class="filter-container" style="margin-bottom: 1rem;">
            <label for="filtro-categoria"><strong>Filtrar por categoria:</strong></label>
            <select id="filtro-categoria" onchange="filtrarPorCategoria()">
                <option value="">Todos</option>
                <?php 
                    // Gera as categorias únicas
                    $categoriasUnicas = array_unique(array_column($dados, 'categoria'));
                    foreach ($categoriasUnicas as $categoria):?>
                        <option value="<?= strtolower(preg_replace('/\s+/', '', $categoria)) ?>"><?= htmlspecialchars($categoria) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="activity-list">
            <?php if ($dados): ?>
                <?php foreach ($dados as $cmd): ?>
                <div class="activity-item" data-categoria="<?= strtolower(preg_replace('/\s+/', '', $cmd['categoria'])) ?>">
                    <div class="activity-content">
                        <div id="exibicao-<?= $cmd['id'] ?>">
                            <p><strong>Comando:</strong> <span><?= htmlspecialchars($cmd['comando']) ?></span></p>
                            <p><strong>Descrição:</strong> <span><?= nl2br(htmlspecialchars($cmd['descricao'])) ?></span></p>
                            <p><strong>Categoria:</strong> <span><?= htmlspecialchars($cmd['categoria']) ?></span></p>
                            <p><strong>Exemplo:</strong> <span><?= htmlspecialchars($cmd['exemplo']) ?></span></p>
                            <p><strong>Criado por:</strong> <span><?= htmlspecialchars($cmd['autor']) ?></span></p>
                            <p class="atalho">
                                <a href=".../component/edit.php"?id=<?= $cmd['id'] ?>" onclick="mostrarFormulario(<?= $cmd['id'] ?>); return false;"><i class="fas fa-pen"></i></a>
                                <a href="../component/delete.php?id=<?= $cmd['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')"><i class="fas fa-trash"></i></a>
                            </p>
                        </div>
                        <form id="form-<?= $cmd['id'] ?>" action="../component/edit.php" method="post" style="display: none;">
                            <input type="hidden" name="id" value="<?= $cmd['id'] ?>">
                            <label>Comando: <input type="text" class="inputwelcome" name="comando" value="<?= htmlspecialchars($cmd['comando']) ?>"></label><br>
                            <label>Descrição: <input type="text" class="inputwelcome" name="descricao" value="<?= htmlspecialchars($cmd['descricao']) ?>"></label><br>
                            <label>Categoria: <input type="text" class="inputwelcome" name="categoria" value="<?= htmlspecialchars($cmd['categoria']) ?>"></label><br>
                            <label>Exemplo: <input type="text" class="inputwelcome" name="exemplo" value="<?= htmlspecialchars($cmd['exemplo']) ?>"></label><br>
                            <button type="submit" class="btn btnhover"><i class="fas fa-floppy-disk"></i> Salvar</button>
                            <button type="button" onclick="cancelarFormulario(<?= $cmd['id'] ?>)" class="btn btn-danger"><i class="fas fa-xmark"></i> Cancelar</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhum comando personalizado cadastrado.</p>
            <?php endif; ?>
            <?php if ($totalPaginas > 1): ?>
                <div class="paginacao">
                    <?php if ($pagina > 1): ?>
                        <a class="btn" href="?pagina=<?= $pagina - 1 ?>">&laquo; Anterior</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <a class="btn <?= ($i == $pagina) ? 'ativo' : '' ?>" href="?pagina=<?= $i ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                    <?php if ($pagina < $totalPaginas): ?>
                        <a class="btn" href="?pagina=<?= $pagina + 1 ?>">Próximo &raquo;</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="<?=$base_url?>public/assets/script/filtro.js"></script>
<script>
    function mostrarFormulario(id){
        document.getElementById('exibicao-' + id).style.display = 'none';
        document.getElementById('form-' + id).style.display = 'block';
    }
    function cancelarFormulario(id){
        document.getElementById('form-' + id).style.display = 'none';
        document.getElementById('exibicao-' + id).style.display = 'block';
    }
</script>