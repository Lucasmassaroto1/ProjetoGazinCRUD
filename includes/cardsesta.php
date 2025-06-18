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
                        <!-- <p><strong>Servidores:</strong> <span id="servers">2</span></p> -->
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
                        <p><strong>Comandos Padrão:</strong> <span id="total-commands">8</span></p>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-content">
                        <p><strong>Slash Comando Padrão:</strong> <span id="total-commands">4</span></p>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-content">
                        <p><strong>Hybrid Comando Padrão:</strong> <span id="total-commands">1</span></p>
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
                    <form id="formAdicionar" action="../component/adicionarfila.php" method="post" style="display: none;">
                        <input type="text" name="titulo" class="inputwelcome" placeholder="Título"><br>
                        <input type="text" name="autor" class="inputwelcome" placeholder="Autor"><br>
                        <button type="submit" class="btn">Adicionar</button>
                        <button type="button" onclick="cancelarFormularioAdicionar()" class="btn ">Cancelar</button>
                    </form>
                <p class="atalho" id='atalho'>
                    <button onclick="mostrarFormularioAdicionar()" class="btn"><i class="fas fa-plus"></i>Adicionar fila</button>
                </p>
        </div>
    </div>
</div>