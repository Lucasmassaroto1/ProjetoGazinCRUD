<?php 
    require_once '../../../includes/controllers/Controller.dashboard.php';

    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Um simples DashBoard para configurar o ByteCode">
    <meta name="author" content="Lucas Massaroto">
    <!-- ======== FAVICON ======== -->
    <link rel="shortcut icon" href="../../../public/img/Favicon/favicon.ico" type="image/x-icon">
    <!-- ======== ESTILO, FONT && ICONS ======== -->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/style/style.css">
    <title>ByteCode DashBoard</title>
</head>
<body class="tema-<?= $tema ?>">
    <?php $base_url = '../../../'; $paginaAtual = 'dashboard'; include '../../../includes/layout/menu.php'; ?>
    <main class="conteudo">
        <?php include '../../../includes/layout/header.php'; ?>
        <?php include '../../../includes/cards/dashboard.php'; ?>
    </main>
    <?php include '../../../includes/layout/footer.php'; ?>
</body>
</html>