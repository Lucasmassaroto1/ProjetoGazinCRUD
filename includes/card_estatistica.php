<link rel="stylesheet" href="<?=$base_url?>public/assets/style/cards.css">
<link rel="stylesheet" href="<?=$base_url?>public/assets/style/embed.css">

<div class="grid-cards">
    <div class="card-status">
        <div class="card-header">
            <i class="fas fa-robot"></i>
            <h2>Status do Bot</h2>
        </div>
        <div class="card-body">
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-content">
                        <p><strong>Status:</strong> <span class="status online">Online</span></p>
                        <p><strong>Tempo Online:</strong> <span id="uptime"> </span></p>
                        <?php if($usuario_tipo === 'admin'):?>
                            <button class="btn btnhover" id="lig-des" onclick="ligdes()">Ligado</button>
                        <?php endif;?>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-content">
                        <p><strong>Prefixo Original:</strong> <span id="original-prefix" class="status-prefix">!</span></p>
                        <p><strong>Prefixo Personalizado:</strong> <span id="custom-prefix" class="status-prefix"><?= htmlspecialchars($prefixo_atual ?? '-') ?></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-status">
        <div class="card-header">
            <i class="fas fa-terminal"></i>
            <h2>Comandos</h2>
        </div>
        <div class="card-body">
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-content">
                        <?php if ($total_commands > 0): ?>
                            <p><strong>Comandos Personalizados:</strong> <span id="total-commands"><?= $total_commands ?></span></p>
                        <?php else: ?>
                            <p>Nenhum comando cadastrado.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-content">
                        <!-- 8 -->
                        <p><strong>Comandos Padrão:</strong> <span><?= $commands_padrao?></span></p>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-content">
                        <!-- 4 -->
                        <p><strong>Slash Commands:</strong> <span><?= $slash_commands_padrao?></span></p>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-content">
                        <!-- 1 -->
                        <p><strong>Hybrid Commands:</strong> <span><?= $hybrid_commands_padrao?></span></p> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-status">
        <div class="card-header">
            <i class="fas fa-users"></i>
            <h2>Welcome Embed</h2>
        </div>
        <div class="card-body">
            <div class="activity-list">
                <div class="activity-content">
                    <div class="grid-cards">
                        <div class="discord-embed">
                            <div class="embed-header">
                                <i class="fas fa-users"></i>
                                <h2><?= $welcome['titulo'] ?? '' ?></h2>
                            </div>
                            <div class="embed-body">
                                <p><?= $mensagemComCargo ?></p>
                            </div>
                            <?php if (!empty($welcome['footer'])): ?>
                            <div class="embed-footer">
                                <span><?= $welcome['footer'] ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-status activity-log">
    <div class="card-header">
        <i class="fas fa-list"></i>
        <h2> Fila de Músicas</h2>
    </div>
    <div class="card-body">
        <div class="activity-list">
            <form id="formAdicionar" action="../component/adicionarfila.php" method="post" style="display: none;">
                <input type="text" name="titulo" class="inputwelcome" placeholder="Título" required><br>
                <input type="text" name="autor" class="inputwelcome" placeholder="Autor" required><br>
                <button type="submit" class="btn btnhover">Adicionar</button>
                <button type="button" onclick="cancelarFormularioAdicionar()" class="btn btnhover">Cancelar</button>
            </form>
            <p class="atalho" id='atalho'>
                <button onclick="mostrarFormularioAdicionar()" class="btn btnhover"><i class="fas fa-plus"></i>Adicionar fila</button>
            </p>
            <?php if ($musica): ?>
                <?php foreach ($musica as $mus): ?>
                <div class="activity-item">
                    <div class="activity-content">
                        <p><strong>Titulo:</strong> <span id="total-commands"><?= htmlspecialchars($mus['titulo']) ?></span></p>
                        <p><strong>Autor:</strong> <span id="commands-today"><?= htmlspecialchars($mus['autor']) ?></span></p>
                        <p><strong>Status:</strong> <span id="commands-today"><?= htmlspecialchars($mus['nome_status']) ?></span></p>
                        <p class="atalho">
                            <a href="../component/delete_musica.php?id=<?= $mus['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')"><i class="fas fa-trash"></i></a>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhuma música adicionada na fila.</p>
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
<script src="<?=$base_url?>public/assets/script/tempo.js"></script>
<script>
    function mostrarFormularioAdicionar(){
        document.getElementById('formAdicionar').style.display = 'block';      
    }
    function cancelarFormularioAdicionar(){
        document.getElementById('formAdicionar').style.display = 'none';
    }
</script>