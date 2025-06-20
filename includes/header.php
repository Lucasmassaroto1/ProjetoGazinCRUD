<link rel="stylesheet" href="<?=$base_url?>public/src/style/header.css">
<header class="welcome">
    <h1>Dashboard do ByteCode</h1>
    <p>Configure o ByteCode de forma simples e rápida.</p>
    <div class="parte-login">
        <div class="avatar">
            <?= strtoupper($_SESSION['usuario_nome'][0]) ?>
        </div>
    </div>
</header>