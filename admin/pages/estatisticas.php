<?php 
    require_once '../../includes/auth.php';
    require_once '../../config/conexao.php';

    $conexao =(new Conexao())->conectar();

    $stmt = $conexao->query("SELECT * FROM conteudo ORDER BY data_criacao DESC");
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total_commands = count($dados);

    $usuario_id = $_SESSION['usuario_id'];
    $stmt = $conexao->prepare("SELECT prefixo_customizado FROM prefixos WHERE usuario_id = ?");
    $stmt->execute([$usuario_id]);
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

    $stmtWelcome = $conexao->prepare("SELECT * FROM welcome WHERE usuario_id = ? ORDER BY id DESC LIMIT 1");
    $stmtWelcome->execute([$usuario_id]);
    $welcome = $stmtWelcome->fetch(PDO::FETCH_ASSOC);

    $stmtmusic = $conexao->prepare("SELECT * FROM musica WHERE usuario_id = ?");
    $stmtmusic->execute([$usuario_id]);
    $musica = $stmtmusic->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Um simples DashBoard para configurar o ByteCode">
    <meta name="author" content="Lucas Massaroto">
    <!-- ======== FAVICON ======== -->
    <link rel="shortcut icon" href="../../public/img/Favicon/favicon.ico" type="image/x-icon">
    <!-- ======== FONT & ICONS ======== -->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- ======== ESTILO ======== -->
    <link rel="stylesheet" href="../src/style/dash.css">

    <!-- ======== ESTILO SEPARADOS ======== -->
    <link rel="stylesheet" href="../../public/src/style/menu.css">
    <link rel="stylesheet" href="../../public/src/style/filtro.css">
    <link rel="stylesheet" href="../../public/src/style/embed.css">
    <title>ByteCode Estatisticas</title>
</head>
<body>
    <?php $base_url = '../../'; $paginaAtual = 'estatistica'; include '../../includes/menu.php'?>
    
    <main class="conteudo">
        <?php include '../../includes/header.php';?>

        <!-- <?php include '../../includes/cardsesta.php';?> -->
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
                                    <p><strong>Comandos Personalizados:</strong> <span id="total-commands"><?= $total_commands ?></span></p>
                                <?php else: ?>
                                    <p>Nenhum comando cadastrado.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-content">
                                <p><strong>Comandos Padrão:</strong> <span id="total-commands">8</span></p>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-content">
                                <p><strong>Slash Comando Padrão:</strong> <span id="total-commands">4</span></p>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-content">
                                <p><strong>Hybrid Comando Padrão:</strong> <span id="total-commands">1</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-status">
                <div class="card-header">
                    <i class="fas fa-users"></i>
                    <h2>Welcome Embed</h2>
                </div>
                <div class="card-body">
                    <div class="activity-list">
                        <div class="activity-content">
                            <div class="grid-cards">
                                <div class="discord-embed">
                                    <div class="embed-header">
                                        <i class="fas fa-users"></i>
                                        <h2><?= $welcome['titulo'] ?? '' ?></h2>
                                    </div>
                                    <div class="embed-body">
                                        <p><?= nl2br($welcome['mensagem'] ?? '') ?></p>
                                    </div>
                                    <?php if (!empty($welcome['footer'])): ?>
                                    <div class="embed-footer">
                                        <span><?= $welcome['footer'] ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-status activity-log">
            <div class="card-header">
                <i class="fas fa-list"></i>
                <h2> Fila de Músicas</h2>
            </div>
            <div class="card-body">
                <div class="activity-list">
                    <?php if ($musica): ?>
                        <?php foreach ($musica as $mus): ?>
                        <div class="activity-item">
                            <div class="activity-content">
                                <p><strong>Titulo:</strong> <span id="total-commands"><?= htmlspecialchars($mus['titulo']) ?></span></p>
                                <p><strong>Autor:</strong> <span id="commands-today"><?= htmlspecialchars($mus['autor']) ?></span></p>
                                <p class="atalho">
                                    <a href="../delete_musica.php?id=<?= $mus['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')"><i class="fas fa-trash"></i></a>
                                </p>

                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <p>Nenhuma música adicionada na fila.</p>
                        <?php endif; ?>
                            <form id="formAdicionar" action="../adicionarfila.php" method="post" style="display: none;">
                                <input type="text" name="titulo" class="inputwelcome" placeholder="Título"><br>
                                <input type="text" name="autor" class="inputwelcome" placeholder="Autor"><br>
                                <button type="submit" class="btn">Adicionar</button>
                                <button type="button" onclick="cancelarFormularioAdicionar()" class="btn ">Cancelar</button>
                            </form>
                        <p class="atalho" id='atalho'>
                            <button onclick="mostrarFormularioAdicionar()"><i class="fas fa-plus"></i>Adicionar fila</button>
                        </p>
                </div>
            </div>
        </div>

    </main>
    <script src="../../public/src/script/menu.js"></script>
    <script src="../../public/src/script/filtro.js"></script>
    <script src="../../public/src/script/tempo.js"></script>
    <script>
        function mostrarFormularioAdicionar(){
            document.getElementById('formAdicionar').style.display = 'block';      
        }
        function cancelarFormularioAdicionar(){
            document.getElementById('formAdicionar').style.display = 'none';
        }
    </script>
</body>
</html>