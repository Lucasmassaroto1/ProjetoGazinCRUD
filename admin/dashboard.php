<?php 
    require_once '../includes/auth.php';
    require_once '../config/conexao.php';

    $conexao =(new Conexao())->conectar();

    $stmt = $conexao->query("SELECT * FROM conteudo ORDER BY data_criacao DESC");
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <p>Configure o ByteCode de forma simples e rápida.</p>
        </header>
        
        <div class="grid-cards">
            <div class="card-status">
                <div class="card-header">
                    <i class="fas fa-robot"></i>
                    <h2>Status do Bot</h2>
                </div>
                <div class="card-body">
                    <p><strong>Status:</strong> <span class="status online">Online</span></p>
                    <p><strong>Tempo Online:</strong> <span id="uptime">2h 30min</span></p>
                    <p><strong>Servidores:</strong> <span id="servers">2</span></p>
                </div>
            </div>

            <div class="card-status">
                <div class="card-header">
                    <i class="fas fa-terminal"></i>
                    <h2>Comandos Personalizados</h2>
                </div>
                <div class="card-body">
                    <?php if ($dados): ?>
                        <?php foreach ($dados as $cmd): ?>
                            <p><strong>Comando:</strong> <span id="total-commands"><?= htmlspecialchars($cmd['comando']) ?></span></p>
                            <!-- <p><strong>Descrição:</strong> <span id="commands-today"><?= nl2br(htmlspecialchars($cmd['descricao'])) ?></span></p>
                            <p><strong>Categoria:</strong> <span id="popular-command"><?= htmlspecialchars($cmd['categoria']) ?></span></p>
                            <p><strong>Exemplo:</strong> <span id="popular-command"><?= htmlspecialchars($cmd['exemplo']) ?></span></p> -->
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7">Nenhum comando cadastrado ainda.</td></tr>
                    <?php endif; ?>
                </div>
            </div>
                    
            <div class="card-status">
                <div class="card-header">
                    <i class="fas fa-robot"></i>
                    <h2>Prefixo Personalizado</h2>
                </div>
                <div class="card-body">
                    <p><strong>Prefixo Original:</strong> <span id="original-prefix" class="status-prefix online">!</span></p>
                    <p><strong>Prefixo Personalizado:</strong> <span id="custom-prefix" class="status-prefix offline">-</span></p>
                </div>
            </div>

            <!-- <div class="card-status">
                <div class="card-header">
                    <i class="fas fa-users"></i>
                    <h2>Usuários</h2>
                </div>
                <div class="card-body">
                    <p><strong>Total:</strong> <span id="total-users">150</span></p>
                    <p><strong>Ativos:</strong> <span id="active-users">45</span></p>
                    <p><strong>Novos hoje:</strong> <span id="new-users">12</span></p>
                </div>
            </div> -->
        </div>
        
        <!-- <div class="grid-cards">
            <div class="card-status">
                <div class="card-header">
                    <i class="fas fa-terminal"></i>
                    <h2>Comandos</h2>
                </div>
                <div class="card-body">
                    <p><strong>Total:</strong> <span id="total-commands">25</span></p>
                    <p><strong>Usados hoje:</strong> <span id="commands-today">156</span></p>
                    <p><strong>Mais popular:</strong> <span id="popular-command">/help</span></p>
                </div>
            </div>
            <div class="card-status">
                <div class="card-header">
                    <i class="fas fa-users"></i>
                    <h2>Em Breve</h2>
                </div>
                <div class="card-body">
                    <p><strong>Em Breve:</strong> <span id="total-users">Sem informações</span></p>
                    <p><strong>Em Breve:</strong> <span id="active-users">Sem informações</span></p>
                    <p><strong>Em Breve:</strong> <span id="new-users">Sem informações</span></p>
                </div>
            </div>
            <div class="card-status">
                <div class="card-header">
                    <i class="fas fa-terminal"></i>
                    <h2>Em Breve</h2>
                </div>
                <div class="card-body">
                    <p><strong>Em Breve:</strong> <span id="total-commands">Sem informações</span></p>
                    <p><strong>Em Breve:</strong> <span id="commands-today">Sem informações</span></p>
                    <p><strong>Em Breve:</strong> <span id="popular-command">/Sem informações</span></p>
                </div>
            </div>
        </div> -->

        <div class="card-status activity-log">
            <div class="card-header">
                <i class="fas fa-terminal"></i>
                <h2> Detalhes Comandos Personalizados</h2>
            </div>
            <div class="card-body">
                <div class="activity-list">
                    <?php if ($dados): ?>
                        <?php foreach ($dados as $cmd): ?>
                    <div class="activity-item">
                        <div class="activity-content">
                                <p><strong>Comando:</strong> <span id="total-commands"><?= htmlspecialchars($cmd['comando']) ?></span></p>
                                <p><strong>Descrição:</strong> <span id="commands-today"><?= nl2br(htmlspecialchars($cmd['descricao'])) ?></span></p>
                                <p><strong>Categoria:</strong> <span id="popular-command"><?= htmlspecialchars($cmd['categoria']) ?></span></p>
                                <p><strong>Exemplo:</strong> <span id="popular-command"><?= htmlspecialchars($cmd['exemplo']) ?></span></p>
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
    <script src="src/script/script.js"></script>
</body>
</html>