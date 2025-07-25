<?php
$itens_menu = [];
if(in_array($paginaAtual, ['dashboard', 'comandos', 'estatistica', 'configuracoes', 'perfil'])){
    $itens_menu[] = ['href' => $base_url . 'admin/views/painel/comandos.php', 'icon' => 'fas fa-terminal', 'label' => 'Comandos', 'active' => ($paginaAtual == 'comandos')];
    $itens_menu[] = ['href' => $base_url . 'admin/views/painel/estatisticas.php', 'icon' => 'fas fa-chart-bar', 'label' => 'Estatísticas', 'active' => ($paginaAtual == 'estatistica')];
    $itens_menu[] = ['href' => $base_url . 'admin/views/painel/configuracoes.php', 'icon' => 'fas fa-cog', 'label' => 'Configurações', 'active' => ($paginaAtual == 'configuracoes')];
    $itens_menu[] = ['href' => $base_url . 'admin/views/painel/perfil.php', 'icon' => 'fas fa-user', 'label' => 'Perfil', 'active' => ($paginaAtual == 'perfil')];
    $itens_menu[] = ['href' => $base_url . 'admin/components/sistema/logout.php', 'icon' => 'fas fa-sign-out-alt', 'label' => 'Sair', 'active' => false];
}
?>
<link rel="stylesheet" href="<?=$base_url?>public/assets/style/layout/menu.css">
<link rel="stylesheet" href="<?=$base_url?>public/assets/style/components/button.css">
<div class="menu">
    <button class="toggle">
        <i class="fa-solid fa-bars"></i>
    </button>
        <nav class="menu-lateral">
            <div class="foto-menu">
                <img id="logo-bytecode" src="<?=$base_url?>public/img/ByteCode.svg" loading="lazy" alt="Foto de perfil do ByteCode">
                <h1>ByteCode <span>um simples bot CLT.</span></h1>
            </div>
            <ul>
                <li><a href="<?=$base_url?>public/index.php" class="<?= ($paginaAtual == 'inicio') ? 'link-ativo' : '' ?>"><i class="fas fa-home"></i> Início</a></li>
                <li><a href="<?=$base_url?>admin/views/painel/dashboard.php" class="<?= ($paginaAtual == 'dashboard') ? 'link-ativo' : '' ?>"><i class="fas fa-table-columns"></i> Dashboard</a></li>
                
                <?php foreach ($itens_menu as $item): ?>
                    <li><a href="<?= $item['href'] ?>" class="<?= $item['active'] ? 'link-ativo' : '' ?>"><i class="<?= $item['icon'] ?>"></i> <?= $item['label'] ?></a></li>
                <?php endforeach; ?>
                <li class="tema-toggle">
                <span><i class="fas fa-palette"></i> Tema</span>
                <label class="switch-tema">
                    <input type="checkbox" id="tema-toggle">
                    <span class="slider"></span>
                </label>
                </li>
            </ul>
        </nav>
    <div class="background"></div>
</div>
<script src="<?=$base_url?>public/assets/script/components/menu.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('tema-toggle');
    const logo = document.getElementById('logo-bytecode');

    <?php
        $tema = 'azul';
        if(isset($_SESSION['usuario_id'])){
            $stmt = $conexao->prepare("SELECT tema FROM usuarios WHERE id = ?");
            $stmt->execute([$_SESSION['usuario_id']]);
            $resultado = $stmt->fetch();
            if($resultado && $resultado['tema'] === 'roxo'){
                $tema = 'roxo';
            }
        }
        echo "toggle.checked = " . ($tema === 'roxo' ? 'true' : 'false') . ";";
    ?>

    toggle.addEventListener('change', () =>{
        const tema = toggle.checked ? 'roxo' : 'azul';
        document.body.classList.remove('tema-azul', 'tema-roxo');
        document.body.classList.add('tema-' + tema);

        fetch('<?=$base_url?>admin/components/sistema/salvarTema.php',{
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'tema=' + encodeURIComponent(tema)
        });
    });

    if(logo){
    logo.addEventListener('click', () =>{
        document.body.classList.remove('tema-azul', 'tema-roxo', 'tema-verde');
        document.body.classList.add('tema-verde');
        toggle.checked = false;
        
        fetch('<?=$base_url?>admin/components/sistema/salvarTema.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'tema=verde'
        });
    });
    }
    });
</script>