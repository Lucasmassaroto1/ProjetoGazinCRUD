<?php
$itens_menu = [];
if(in_array($paginaAtual, ['dashboard', 'comandos', 'estatistica', 'configuracoes', 'perfil'])){
    $itens_menu[] = ['href' => $base_url . 'admin/views/painel/comandos.php', 'icon' => 'fas fa-terminal', 'label' => 'Comandos', 'active' => ($paginaAtual == 'comandos')];
    $itens_menu[] = ['href' => $base_url . 'admin/views/painel/estatisticas.php', 'icon' => 'fas fa-chart-bar', 'label' => 'Estatísticas', 'active' => ($paginaAtual == 'estatistica')];
    $itens_menu[] = ['href' => $base_url . 'admin/views/painel/configuracoes.php', 'icon' => 'fas fa-cog', 'label' => 'Configurações', 'active' => ($paginaAtual == 'configuracoes')];
    $itens_menu[] = ['href' => $base_url . 'admin/views/painel/perfil.php', 'icon' => 'fas fa-user', 'label' => 'Perfil', 'active' => ($paginaAtual == 'perfil')];
    $itens_menu[] = ['href' => $base_url . 'admin/component/sistema/logout.php', 'icon' => 'fas fa-sign-out-alt', 'label' => 'Sair', 'active' => false];
}
?>
<link rel="stylesheet" href="<?=$base_url?>public/assets/style/components/menu.css">
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
                <li><a href="<?=$base_url?>admin/views/painel/dashboard.php" class="<?= ($paginaAtual == 'dashboard') ? 'link-ativo' : '' ?>"><i class="fas fa-table-columns"></i> Dashboard</a></li>
                
                <?php foreach ($itens_menu as $item): ?>
                    <li><a href="<?= $item['href'] ?>" class="<?= $item['active'] ? 'link-ativo' : '' ?>"><i class="<?= $item['icon'] ?>"></i> <?= $item['label'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>
    <div class="background"></div>
</div>
<script src="<?=$base_url?>public/assets/script/components/menu.js" defer></script>