<link rel="stylesheet" href="<?=$base_url?>public/assets/style/components/card.css">
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
                        <p><strong>Comandos Padrão:</strong> <span><?= $commands_padrao?></span></p>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-content">
                        <p><strong>Slash Commands:</strong> <span><?= $slash_commands_padrao?></span></p>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-content">
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
        <h2>Em Breve</h2>
    </div>
    <div class="card-body">
        <div class="activity-list">
            <div class="activity-item">
                <div class="activity-content">
                    <p>Sem Informações</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?=$base_url?>public/assets/script/features/tempo.js"></script>