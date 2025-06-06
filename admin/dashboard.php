<?php 
    require_once '../includes/auth.php';
    require_once '../config/conexao.php';

    $conexao =(new Conexao())->conectar();

    $stmt = $conexao->query("SELECT * FROM conteudo ORDER BY data_criacao DESC");
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $total_commands = count($dados);

    $stmt = $conexao->query("SELECT prefixo_customizado FROM prefixos ORDER BY id DESC LIMIT 1");
    $prefixo_atual = $stmt->fetchColumn();

    $usuario_id = $_SESSION['usuario_id'];
    $usuario_tipo = $_SESSION['usuario_tipo'];

    if($usuario_tipo === 'admin'){
        $sql = "SELECT c.*, u.usuario AS autor FROM conteudo c JOIN usuarios u ON c.criado_por = u.id ORDER BY c.data_criacao DESC";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
    }else{
        $sql = "SELECT c.*, u.usuario AS autor FROM conteudo c JOIN usuarios u ON c.criado_por = u.id WHERE c.criado_por = ? ORDER BY c.data_criacao DESC";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$usuario_id]);
    }
    $conteudos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Um simples DashBoard para configurar o ByteCode">
    <meta name="author" content="Lucas Massaroto">
    <!-- ======== FAVICON ======== -->
    <link rel="shortcut icon" href="../public/img/Favicon/favicon.ico" type="image/x-icon">
    <!-- ======== FONT & ICONS ======== -->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- ======== ESTILO & RESPONSIVIDADE ======== -->
    <link rel="stylesheet" href="src/style/style.css">
    <link rel="stylesheet" href="src/style/responsivel.css">
    <link rel="stylesheet" href="../public/src/style/menu.css">
    <title>ByteCode DashBoard</title>
</head>
<body>
    <?php include '../includes/menu.php'?>
    <main class="conteudo">
        <header class="welcome">
            <h1>Dashboard do ByteCode</h1>
            <p>Bem-vindo<?= ($_SESSION['usuario_nome'][-1] == 'a') ? 'a' : '' ?>, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>! Configure o ByteCode de forma simples e rápida.</p>
        </header>
        
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
                                <p><strong>Servidores:</strong> <span id="servers">2</span></p>
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
                                    <p><strong>Total Comandos Personalizados:</strong> <span id="total-commands"><?= $total_commands ?></span></p>
                                <?php else: ?>
                                    <p>Nenhum comando cadastrado.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-content">
                                <?php if ($total_commands > 0): ?>
                                    <p><strong>Total Comando Padrão:</strong> <span id="total-commands"><?= $total_commands + 13 ?></span></p>
                                <?php endif; ?>
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
        </div>

        <div class="card-status activity-log">
            <div class="card-header">
                <i class="fas fa-terminal"></i>
                <h2> Detalhes Comandos Personalizados</h2>
            </div>
            <div class="card-body">
                <div class="activity-list">
                    <?php if ($conteudos): ?>
                        <?php foreach ($conteudos as $cmd): ?>
                    <div class="activity-item">
                        <div class="activity-content">
                                <p><strong>Comando:</strong> <span id="total-commands"><?= htmlspecialchars($cmd['comando']) ?></span></p>
                                <p><strong>Descrição:</strong> <span id="commands-today"><?= nl2br(htmlspecialchars($cmd['descricao'])) ?></span></p>
                                <p><strong>Categoria:</strong> <span id="popular-command"><?= htmlspecialchars($cmd['categoria']) ?></span></p>
                                <p><strong>Exemplo:</strong> <span id="popular-command"><?= htmlspecialchars($cmd['exemplo']) ?></span></p>
                                <p><strong>Criado por:</strong> <span id="popular-command"><?= htmlspecialchars($cmd['autor']) ?></span></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7">Nenhum comando personalizado cadastrado.</td></tr>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <script src="../public/src/script/script.js"></script>
</body>
</html>