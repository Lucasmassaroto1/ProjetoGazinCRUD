<link rel="stylesheet" href="<?=$base_url?>public/assets/style/layout/header.css">
<header class="welcome">
    <h1>Dashboard do ByteCode</h1>
    <p>Configure o ByteCode de forma simples e rápida.</p>
    <div class="parte-login">
        <div class="fundo"></div>
        <div class="avatar">
            <?php if (!empty($user['foto_perfil'])): ?>
                <img src="<?=$base_url?>public/uploads/<?= htmlspecialchars($user['foto_perfil']) ?>" alt="Foto de perfil">
            <?php else: ?>
                <?= strtoupper($_SESSION['usuario_nome'][0]) ?>
            <?php endif; ?>
        </div>
        <div class="avahover">
            <?= strtoupper($_SESSION['usuario_nome']) ?>
        </div>
    </div>
</header>