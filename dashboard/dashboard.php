<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Um simples DashBoard para configurar o ByteCode">
    <meta name="author" content="Lucas Massaroto">
    <!-- ======== FAVICON ======== -->
    <link rel="shortcut icon" href="../principal/img/Favicon/favicon.ico" type="image/x-icon">
    <!-- ======== FONT & ICONS ======== -->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- ======== ESTILO & RESPONSIVIDADE ======== -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="responsivel.css">
    <title>ByteCode DashBoard</title>
</head>
<body>
    <div class="menu">
        <button class="toggle">
            <i class="fa-solid fa-bars"></i>
        </button>
            <nav class="menu-lateral">
                <div class="foto-menu">
                    <img src="../public/assets/img/ByteCode.svg" loading="lazy" alt="Foto de perfil do ByteCode">
                    <h1>ByteCode <span>um simples bot CLT.</span></h1>
                </div>
                <ul>
                    <li><a href="../principal/home.php"><i class="fas fa-home"></i> Início</a></li>
                    <li><a href="#comandos"><i class="fas fa-terminal"></i> Comandos</a></li>
                    <li><a href="#estatisticas"><i class="fas fa-chart-bar"></i> Estatísticas</a></li>
                    <li><a href="#configuracoes"><i class="fas fa-cog"></i> Configurações</a></li>
                    <li><a href="#sair"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                </ul>
            </nav>
            <div class="background"></div>
    </div>
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
                    <i class="fas fa-users"></i>
                    <h2>Usuários</h2>
                </div>
                <div class="card-body">
                    <p><strong>Total:</strong> <span id="total-users">150</span></p>
                    <p><strong>Ativos:</strong> <span id="active-users">45</span></p>
                    <p><strong>Novos hoje:</strong> <span id="new-users">12</span></p>
                </div>
            </div>
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
        </div>
        
        <div class="grid-cards">
            <div class="card-status">
                <div class="card-header">
                    <i class="fas fa-robot"></i>
                    <h2>Prefixo</h2>
                </div>
                <div class="card-body">
                    <p><strong>Prefixo Original:</strong> <span id="original-prefix" class="status-prefix online">!</span></p>
                    <p><strong>Prefixo Personalizado:</strong> <span id="custom-prefix" class="status-prefix offline">-</span></p>
                    <p><input type="text" name="" id="input-prefix" class="input-prefix" placeholder="Digite o prefixo" maxlength="1"></p>
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
        </div>

        <div class="card-status activity-log">
            <div class="card-header">
                <i class="fas fa-history"></i>
                <h2>Atividades Recentes</h2>
            </div>
            <div class="card-body">
                <div class="activity-list">
                    <div class="activity-item">
                        <i class="fas fa-user-plus"></i>
                        <div class="activity-content">
                            <p>Novo usuário registrado</p>
                            <small>Há 5 minutos</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <i class="fas fa-terminal"></i>
                        <div class="activity-content">
                            <p>Comando /help executado</p>
                            <small>Há 10 minutos</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <i class="fas fa-server"></i>
                        <div class="activity-content">
                            <p>Novo servidor adicionado</p>
                            <small>Há 30 minutos</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="script.js"></script>
</body>
</html>