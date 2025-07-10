<link rel="stylesheet" href="<?=$base_url?>public/assets/style/components/card.css">
<div class="grid-cards">
    <div class="card-status">
        <div class="card-header">
            <i class="fas fa-users"></i>
            <h2>Welcome Embed Config</h2>
        </div>
        <div class="card-body">
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-content">
                        <h2>Escolha um canal</h2>
                        <select name="welcome-chanenel" id="welcome-channel" class="form-select">
                            <option value="">Selecione um canal</option>
                            <option value="123">#geral</option>
                            <option value="124">#boas-vindas</option>
                            <option value="125">#novatos</option>
                        </select>
                        <button class="btn btn-salvar"><i class="fas fa-floppy-disk"></i> Salvar configurações</button>
                    </div>
                </div>
                <h2>Mensagem Personalizada:</h2>
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

    <div class="card-status">
        <div class="card-header">
            <i class="fas fa-robot"></i>
            <h2>Cargo automático ao entrar </h2>
        </div>
        <div class="card-body">
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-content">
                        <h2>Escolha um cargo</h2>
                        <form method="post">
                            <select id="autorole" name="cargo_auto" class="form-select">
                                <option value="">Nenhum</option>
                                <option value="@Membro" <?= ($cargo_auto ?? '') == '@Membro' ? 'selected' : '' ?>>@Membro</option>
                                <option value="@VIP" <?= ($cargo_auto ?? '') == '@VIP' ? 'selected' : '' ?>>@VIP</option>
                            </select>
                            <button type="submit" class="btn btn-salvar"><i class="fas fa-floppy-disk"></i> Salvar Cargo</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-status">
        <div class="card-header">
            <i class="fas fa-music"></i>
            <h2>Informações Música</h2>
        </div>
        <div class="card-body">
            <div class="activity-list">
                <?php foreach (array_slice($musica, 0, 2) as $mus): ?>
                    <div class="activity-content">
                        <div class="grid-cards">
                            <div class="discord-embed-music">
                                <div class="embed-header-music">
                                    <i class="fas fa-music"></i>
                                    <h2>Informações Dj ByteCode</h2>
                                </div>
                                <div class="embed-body-music">
                                    <img src="../../../public/img/ByteCodeMusic.svg" alt="">
                                    <p><strong>Música:</strong> <?= htmlspecialchars($mus['titulo']) ?></p>
                                    <p><strong>Artista:</strong> <?= htmlspecialchars($mus['autor']) ?></p>
                                    <p><strong>Status:</strong> <?= htmlspecialchars($mus['nome_status']) ?></p>
                                </div>
                                <div class="embed-footer-music">
                                    <span>Dj ByteCode</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="activity-item volume-card">
                    <div class="activity-content music-painel">
                        <div class="activity-content music-painel">
                            <i class="fas fa-backward-step" onclick="volta()"></i> <i class="fas fa-play" id="play-pause" onclick="tocar()"></i> <i class="fas fa-forward-step" onclick="passa()"></i>
                        </div>

                            <i class="fas fa-volume-high volume-icon" onclick="mostravolume()"></i>
                        
                        <div class="activity-content volume-controls"  id="volume-controls" style="display: none;">
                            <i class="fas fa-minus" onclick="alterarVolume(-10)"></i><span id="volume-valor"><?= $volume ?>%</span><i class="fas fa-plus" onclick="alterarVolume(10)"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<script src="<?=$base_url?>public/assets/script/components/musica.js"></script>