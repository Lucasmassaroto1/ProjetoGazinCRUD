
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ByteCode, Um simples Bot CLT, criado para ajudar e entreter os usuários">
    <meta name="author" content="Lucas Massaroto">
    <!-- ========== FONTES & ICONS ========== -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- ========== FAVICON ========== -->
    <link rel="shortcut icon" href="assets/img/Favicon/favicon.ico" type="image/x-icon">
    <!-- ========== ESTILOS & LOADING ========== -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsivel.css">
    <script src="assets/script/loading.js"></script>
    <title>ByteCode CRUD</title>
</head>
<body>
    <div class="terminal-loader" id="loader">
        <div class="terminal-header">
            <div class="terminal-title">Status</div>
            <div class="terminal-controls">
            <div class="control close"></div>
            <div class="control minimize"></div>
            <div class="control maximize"></div>
            </div>
        </div>
        <div class="text">Loading...</div>
    </div>
    <header class="fade">
        <button class="toggle">
            <i class="fa-solid fa-bars"></i>
        </button>
        <nav class="menu-lateral">
            <ul>
                <li><a href="#inicio"><i class="fa-solid fa-house"></i><span>Inicio</span></a></li>
                <li><a href="#sobre"><i class="fa-solid fa-circle-info"></i><span>Sobre</span></a></li>
                <!-- <li><a href="#comando"><i class="fa-solid fa-gears"></i><span>Comandos</span></a></li> -->
                <li><a href="../admin/dashboard.php"><i class="fa-solid fa-gears"></i><span>Painel</span></a></li>
                <!-- <li><a href="https://discord.com/oauth2/authorize?client_id=1309200248987586560&scope=bot&permissions=1759218604441591&intents=65535" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-plus"></i><span>Invite</span></a></li>
                <li><a href="https://discord.gg/Bs9pMBnDX3" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-discord"></i><span>Comunidade</span></a></li> -->
                <li><button id="toggleTheme"><i class="fa-solid fa-moon"></i></button></li>
            </ul>
        </nav>
        <div class="background"></div>
    </header>
    <main class="conteudo">
        <button id="voltarTopo" class="voltar-topo">↑</button>
        <section class="inicio fade" id="inicio">
            <div class="flex">
                <div class="img-inicio">
                    <img class="bytefoto" src="assets/img/ByteCode.svg" alt="ByteCodeLogo">
                </div>
                <div class="txt-inicio">
                    <h1>ByteCode, <span>um simples bot CLT.</span></h1>
                    <div class="btn-global">
                        <button onclick="window.open('https://discord.com/oauth2/authorize?client_id=1309200248987586560&scope=bot&permissions=1759218604441591&intents=65535', '_blank')" type="button"><i class="fa-solid fa-robot"></i> Me adicione</button>
                        <button onclick="window.open('https://discord.gg/Bs9pMBnDX3', '_blank')" type="button"><i class="fa-brands fa-discord"></i> Comunidade</button>
                    </div>
                    <div class="individual">
                        <button onclick="window.open('https://github.com/Lucasmassaroto1/botdiscord', '_blank')" type="button"><i class="fa-solid fa-code"></i> Meu Código</button>
                    </div>
                </div>
            </div>
        </section>
        <section class="sobre fade" id="sobre">
            <div class="flex">
                <div class="txt-sobre">
                    <h2 class="titulo">Venha conhecer o <span>ByteCode.</span></h2>
                    <p>Olá, sou <strong>ByteCode</strong>, um simples bot CLT criado para auxiliar e entreter os usuários. Comigo, você pode tocar músicas, traduzir textos, jogar e muito mais. Fui desenvolvido por <strong>Lucas Massaroto</strong>.</p>
                    <p>Sou um projeto de codigo aberto, permitindo que qualquer pessoa faça modificações e rode sua própria versão do bot localmente no computador. Se você quiser dar uma olhada no código ou contribuir, acesse o <a href="https://github.com/Lucasmassaroto1/botdiscord" target="_blank" rel="noopener noreferrer">repositório no GitHub</a>.</p>
                    <p><strong>Junte-se à comunidade ByteCode!</strong> <a href="https://discord.gg/Bs9pMBnDX3" target="_blank" rel="noopener noreferrer">Clique aqui</a> para entrar no nosso servidor e ficar por dentro de novidades, atualizações e suporte.</p>
                </div>
            </div>
        </section>
        <section class="comando slide-right" id="comando">
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

            <!-- <article class="card glow-effect">
                <div class="card-image">
                    <img src="assets/img/ByteCode.svg" loading="lazy" alt="ByteCodeLogo" />
                </div>
                <div class="category">Slash Commands</div>
                <div class="heading">
                    <ul class="list-commands">
                        <li>/ajuda</li>
                        <li>/sobre</li>
                        <li>/invite</li>
                        <li>/falar</li>
                    </ul>
                </div>
                <div class="author">By <span class="name">Lucas Massaroto.</span></div>
            </article>
            <article class="card glow-effect">
                <div class="card-image">
                    <img src="assets/img/ByteCode.svg" loading="lazy" alt="ByteCodeLogo" />
                </div>
                <div class="category">Comunicação</div>
                <div class="heading">
                    <ul class="list-commands">
                        <li>!translate</li>
                    </ul>
                </div>
                <div class="author">By <span class="name">Lucas Massaroto.</span></div>
            </article>
            <article class="card glow-effect">
                <div class="card-image">
                    <img src="assets/img/ByteCode.svg" loading="lazy" alt="ByteCodeLogo" />
                </div>
                <div class="category">Diversão</div>
                <div class="heading">
                    <ul class="list-commands">
                        <li>!ppt</li>
                    </ul>
                </div>
                <div class="author">By <span class="name">Lucas Massaroto.</span></div>
            </article> 
            <article class="card glow-effect">
                <div class="card-image">
                    <img src="assets/img/ByteCode.svg" loading="lazy" alt="ByteCodeLogo" />
                </div>
                <div class="category">Música</div>
                <div class="heading">
                    <ul class="list-commands">
                        <li>!play</li>
                        <li>!pause</li>
                        <li>!skip</li>
                        <li>!leave</li>
                    </ul>
                </div>
                <div class="author">By <span class="name">Lucas Massaroto.</span></div>
            </article>
            <article class="card glow-effect">
                <div class="card-image">
                    <img src="assets/img/ByteCode.svg" loading="lazy" alt="ByteCodeLogo" />
                </div>
                <div class="category">Moderação</div>
                <div class="heading">
                    <ul class="list-commands">
                        <li>!clear</li>
                        <li>!setwelcome</li>
                    </ul>
                </div>
                <div class="author">By <span class="name">Lucas Massaroto.</span></div>
            </article>
            <article class="card glow-effect">
                <div class="card-image">
                    <img src="assets/img/ByteCode.svg" loading="lazy" alt="ByteCodeLogo" />
                </div>
                <div class="category">HybridCommands</div>
                <div class="heading">
                    <ul class="list-commands">
                        <li>/prefix ou !prefix</li>
                    </ul>
                </div>
                <div class="author">By <span class="name">Lucas Massaroto.</span></div>
            </article> -->
        </section>
        <section class="fade" id="criador">
            <div class="criador-container">
                <h2 class="titulo">Criador</h2>
                <div class="perfil">
                    <img src="https://avatars.githubusercontent.com/u/102060111?v=4" alt="Foto do Lucas Massaroto criador do ByteCode" class="foto-perfil" loading="lazy"> 
                <div class="texto">
                    <h3>Lucas Massaroto</h3>
                    <p>Desenvolvedor FullStack e criador do ByteCode, apaixonado por tecnologia, programação e automação. Buscando sempre evoluir e trazer ideias úteis para a comunidade!</p>
                <div class="btn-global redes">
                    <button onclick="window.open('https://www.tiktok.com/@lucasmassaroto1', '_blank')" type="button"><i class="fa-brands fa-tiktok"></i></button>
                    <button onclick="window.open('https://www.instagram.com/lucasmassaroto17', '_blank')" type="button"><i class="fa-brands fa-instagram"></i></button>
                    <button onclick="window.open('mailto:lucasmassaroto17@gmail.com')" type="button"><i class="fa-solid fa-envelope"></i></button>
                </div>
                </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div class="line-footer">
            <div class="btn-global">
                <button onclick="window.open('https://discord.com/oauth2/authorize?client_id=1309200248987586560&scope=bot&permissions=1759218604441591&intents=65535', '_blank')" type="button"><i class="fa-solid fa-robot"></i></button>
                <button onclick="window.open('https://discord.gg/Bs9pMBnDX3', '_blank')" type="button"><i class="fa-brands fa-discord"></i></button>
                <button onclick="window.open('https://github.com/Lucasmassaroto1/botdiscord', '_blank')" type="button"><i class="fa-solid fa-code"></i></button>
            </div>
        </div>
        <div class="line-footer borda">
            <p>&copy; Developed By <a href="https://github.com/Lucasmassaroto1" target="_blank" rel="noopener noreferrer">Lucas Massaroto.</a></p>
        </div>
    </footer>
    <script src="assets/script/script.js"></script>
</body>
</html>