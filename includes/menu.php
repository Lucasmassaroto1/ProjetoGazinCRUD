<div class="menu">
    <button class="toggle">
        <i class="fa-solid fa-bars"></i>
    </button>
        <nav class="menu-lateral">
            <div class="foto-menu">
                <img src="<?=$base_url?>public/img/ByteCode.svg" loading="lazy" alt="Foto de perfil do ByteCode">
                <h1>ByteCode <span>um simples bot CLT.</span></h1>
            </div>
            <ul>
                <li><a href="<?=$base_url?>public/index.php" class="<?= ($paginaAtual == 'inicio') ? 'link-ativo' : '' ?>"><i class="fas fa-home"></i> Início</a></li>
                <li><a href="<?=$base_url?>admin/dashboard.php" class="<?= ($paginaAtual == 'dashboard') ? 'link-ativo' : '' ?>"><i class="fas fa-terminal"></i> Dashboard</a></li>
                <?php if ($paginaAtual == 'dashboard'): ?>
                    <li><a href="<?= $base_url ?>admin/pages/comandos.php" class="<?= ($paginaAtual == 'comandos') ? 'link-ativo' : '' ?>"><i class="fas fa-terminal"></i> Comandos</a></li>
                    <?php endif; ?>
                    <li><a href="<?=$base_url?>admin/pages/estatisticas.php" class="<?= ($paginaAtual == 'estatistica') ? 'link-ativo' : '' ?>"><i class="fas fa-chart-bar"></i> Estatísticas</a></li>
                    <li><a href="<?=$base_url?>admin/pages/configuracoes.php" class="<?= ($paginaAtual == 'configuracoes') ? 'link-ativo' : '' ?>"><i class="fas fa-cog"></i> Configurações</a></li>
                <?php if ($paginaAtual == 'dashboard' || $paginaAtual == 'comandos' || $paginaAtual == 'estatistica' || $paginaAtual == 'configuracoes'): ?>
                    <li><a href="<?=$base_url?>admin/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    <div class="background"></div>
</div>



<!-- <div class="menu">
    <button class="toggle">
        <i class="fa-solid fa-bars"></i>
    </button>
        <nav class="menu-lateral">
            <div class="foto-menu">
                <img src="../public/img/ByteCode.svg" loading="lazy" alt="Foto de perfil do ByteCode">
                <h1>ByteCode <span>um simples bot CLT.</span></h1>
            </div>
            <ul>
                <li><a href="../public/index.php"><i class="fas fa-home"></i> Início</a></li>
                <li><a href="pages/comandos.php"><i class="fas fa-terminal"></i> Comandos</a></li>
                <li><a href="#estatisticas"><i class="fas fa-chart-bar"></i> Estatísticas</a></li>
                <li><a href="#configuracoes"><i class="fas fa-cog"></i> Configurações</a></li>
                <li><a href="../admin/login.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
            </ul>
        </nav>
    <div class="background"></div>
</div> -->