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
</div>