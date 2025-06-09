<?php 
    require_once '../includes/auth.php';
    require_once '../config/conexao.php';

    $conexao =(new Conexao())->conectar();

    $stmt = $conexao->query("SELECT * FROM conteudo ORDER BY data_criacao DESC");
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $total_commands = count($dados);

    $stmt = $conexao->query("SELECT prefixo_customizado FROM prefixos ORDER BY id DESC LIMIT 1");
    $prefixo_atual = $stmt->fetchColumn();

    $conteudos = [];

    if(isset($_SESSION['usuario_id'], $_SESSION['usuario_tipo'])){
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

        // Consulta welcome só se estiver logado
        $stmtWelcome = $conexao->prepare("SELECT * FROM welcome WHERE usuario_id = ?");
        $stmtWelcome->execute([$usuario_id]);
        $welcome = $stmtWelcome->fetch(PDO::FETCH_ASSOC);
    }else{
        // Consulta pública padrão (sem filtrar por autor)
        $sql = "SELECT c.*, u.usuario AS autor FROM conteudo c JOIN usuarios u ON c.criado_por = u.id ORDER BY c.data_criacao DESC";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $conteudos = $stmt->fetchAll();

        // Você pode definir $welcome como nulo
        $welcome = null;
    }

?>
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
    <link rel="shortcut icon" href="img/Favicon/favicon.ico" type="image/x-icon">
    <!-- ========== ESTILOS & LOADING ========== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="src/style/style.css">
    <link rel="stylesheet" href="src/style/responsivel.css">

    <link rel="stylesheet" href="src/style/menu.css">
    <link rel="stylesheet" href="src/style/embed.css">

    <script src="src/script/loading.js"></script>

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
                <li><a href="#inicio" class='link-ativo'><i class="fa-solid fa-house"></i><span>Inicio</span></a></li>
                <li><a href="#sobre"><i class="fa-solid fa-circle-info"></i><span>Sobre</span></a></li>
                <li><a href="../admin/login.php"><i class="fa-solid fa-gears"></i><span>Painel</span></a></li>
            </ul>
        </nav>
        <div class="background"></div>
    </header>
    <main class="conteudo">
        <button id="voltarTopo" class="voltar-topo">↑</button>
        <section class="inicio fade" id="inicio">
            <div class="flex">
                <div class="img-inicio">
                    <img class="bytefoto" src="img/ByteCode.svg" alt="ByteCodeLogo">
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

        <div class="container-card fade">
            <?php include '../includes/cards.php'?>
        </div>

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
    <script src="src/script/menu.js"></script>
    <script src="src/script/script.js"></script>
    <script src="src/script/tempo.js"></script>
</body>
</html>