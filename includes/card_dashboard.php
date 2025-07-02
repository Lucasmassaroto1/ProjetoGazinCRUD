<link rel="stylesheet" href="<?=$base_url?>public/assets/style/filtro.css">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-status">
        <div class="card-header">
            <i class="fas fa-terminal"></i>
            <h2>Comandos total</h2>
        </div>
        <div class="card-body">
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-content">
                        <?php if ($total_commands > 0): ?>
                            <p><strong>Comandos Personalizados:</strong> <span><?= $total_commands ?></span></p>
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
                        <p><strong>Slash Comando Padrão:</strong> <span><?= $slash_commands_padrao?></span></p>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-content">
                        <!-- 1 -->
                        <p><strong>Hybrid Comando Padrão:</strong> <span><?= $hybrid_commands_padrao?></span></p> 
                    </div>
                </div>
            </div>
        </div>
    </div>
            
    <div class="card-status">
        <div class="card-header">
            <i class="fas fa-robot"></i>
            <h2>Prefixo Personalizado</h2>
        </div>
        <div class="card-body">
            <div class="activity-list">
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
        <i class="fas fa-terminal"></i>
        <h2> Detalhes Comandos Personalizados</h2>
    </div>
    <div class="card-body">
        <?php 
            require_once '../config/conexao.php';
            $conexao = (new Conexao())->conectar();

            $stmtCategorias = $conexao->query("SELECT DISTINCT categoria FROM conteudo ORDER BY categoria ASC");
            $categoriasUnicas = $stmtCategorias->fetchAll(PDO::FETCH_COLUMN);
        ?>
        <div class="filter-container" style="margin-bottom: 1rem;">
            <label for="filtro-categoria"><strong>Filtrar por categoria:</strong></label>
            <select id="filtro-categoria" onchange="filtrarPorCategoria()">
                <option value="">Todos</option>
                <?php foreach ($categoriasUnicas as $categoria): ?>
                    <option value="<?= strtolower(preg_replace('/\s+/', '', $categoria)) ?>">
                        <?= htmlspecialchars($categoria) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="activity-list" id="lista-comandos"></div>
    </div>
</div>
<script src="<?=$base_url?>public/assets/script/filtro.js"></script>
<script src="<?=$base_url?>public/assets/script/tempo.js"></script>
<script src="<?=$base_url?>public/assets/script/lista_pagina.js"></script>