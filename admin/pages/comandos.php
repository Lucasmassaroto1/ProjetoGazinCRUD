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

    $stmtWelcome = $conexao->prepare("SELECT * FROM welcome WHERE usuario_id = ?");
    $stmtWelcome->execute([$usuario_id]);
    $welcome = $stmtWelcome->fetch(PDO::FETCH_ASSOC);
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
    <!-- ======== ESTILO & RESPONSIVIDADE ======== -->
    <link rel="stylesheet" href="../src/style/style.css">
    <link rel="stylesheet" href="../src/style/responsivel.css">
    <link rel="stylesheet" href="../../public/src/style/menu.css">
    <title>ByteCode DashBoard</title>
</head>
<body>
    <div class="menu">
        <button class="toggle">
            <i class="fa-solid fa-bars"></i>
        </button>
            <nav class="menu-lateral">
                <div class="foto-menu">
                    <img src="../../public/img/ByteCode.svg" loading="lazy" alt="Foto de perfil do ByteCode">
                    <h1>ByteCode <span>um simples bot CLT.</span></h1>
                </div>
                <ul>
                    <li><a href="../dashboard.php"><i class="fas fa-home"></i> Início</a></li>
                    <li><a href="pages/comandos.php"><i class="fas fa-terminal"></i> Comandos</a></li>
                    <li><a href="#estatisticas"><i class="fas fa-chart-bar"></i> Estatísticas</a></li>
                    <li><a href="#configuracoes"><i class="fas fa-cog"></i> Configurações</a></li>
                    <li><a href="../login.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                </ul>
            </nav>
        <div class="background"></div>
    </div>
    <main class="conteudo">
        <header class="welcome">
            <h1>Comandos do ByteCode</h1>
            <p>Bem-vindo<?= ($_SESSION['usuario_nome'][-1] == 'a') ? 'a' : '' ?>, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>! Configure o ByteCode de forma simples e rápida.</p>
        </header>
        
        <div class="grid-cards">
            <div class="card-status">
                <div class="card-header">
                    <i class="fas fa-terminal"></i>
                    <h2>Comandos Personalizados</h2>
                </div>
                <div class="card-body">
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-content">
                                <?php if ($conteudos): ?>
                                    <?php foreach ($conteudos as $cmd): ?>
                                        <p><strong>Comando:</strong> <span id="total-commands"><?= htmlspecialchars($cmd['comando']) ?></span></p>
                                        <p class="atalho">
                                            <a href="../create.php">+ Novo Comando</a>
                                        </p>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Crie um comando personalizado Aqui.</p>
                                    <p class="atalho">
                                        <a href="../create.php"><i class="fas fa-plus"></i></a>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
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
                        <form action="../valida_prefix.php" method="post">
                            <p><strong>Prefixo Original:</strong> <span id="original-prefix" class="status-prefix">!</span></p>
                            <p><strong>Prefixo Personalizado:</strong> <span id="custom-prefix" class="status-prefix"><?= htmlspecialchars($prefixo_atual ?? '-') ?></span></p>
                            <p><input type="text" name="prefixo" id="input-prefix" class="input-prefix" placeholder="Digite o prefixo" maxlength="1"></p>
                            <button type="submit" class="btn btn-primary">Salvar Prefixo</button>
                        </form>
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
                    <i class="fas fa-users"></i>
                    <h2>Welcome</h2>
                </div>
                <div class="card-body">
                <div class="activity-list">
                    <?php if ($welcome): ?>
                        <div class="activity-item">
                            <div class="activity-content">
                                <div id="exibicao-<?= $wel['id'] ?>">
                                    
                                    <input type="text" name="titulo" class="inputwelcome" placeholder="Titulo" required>
                                    <input type="text" name="mensagem" class="inputwelcome"  placeholder="Mensagem" required>
                                    <!-- <input type="text" name="imagem" class="inputwelcome"  placeholder="Imagem">     -->

                                    <p><strong>Titulo:</strong> <span id="total-commands"><?= htmlspecialchars($welcome['titulo']) ?></span></p>
                                    <p><strong>Mensagem:</strong> <span id="commands-today"><?= nl2br(htmlspecialchars($welcome['mensagem'])) ?></span></p>
                                    <p><strong>Imagem:</strong> <span id="popular-command"><?= htmlspecialchars($welcome['categoria']) ?></span></p>
                                    <p><strong>Criado por:</strong> <span id="popular-command"><?= htmlspecialchars($welcome['autor']) ?></span></p>
                                    <p class="atalho">
                                        <a href="../edit.php?id=<?= $cmd['id'] ?>" onclick="mostrarFormulario(<?= $cmd['id'] ?>); return false;"><i class="fas fa-pen"></i></a>
                                        <a href="../delete.php?id=<?= $cmd['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')"><i class="fas fa-trash"></i></a>
                                    </p>
                                </div>
                                <form id="form-<?= $cmd['id'] ?>" action="../edit.php" method="post" style="display: none;">
                                    <input type="hidden" name="id" value="<?= $cmd['id'] ?>">
                                    <label>Titulo: <input type="text" name="titulo" value="<?= htmlspecialchars($cmd['titulo']) ?>"></label><br>
                                    <label>Mensagem: <input type="text" name="mensagem" value="<?= htmlspecialchars($cmd['mensagem']) ?>"></label><br>
                                    <button type="submit" class="btn btn-sm btn-success">Salvar</button>
                                    <button type="button" onclick="cancelarFormulario(<?= $cmd['id'] ?>)" class="btn btn-sm btn-secondary">Cancelar</button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <p>Nenhuma Mensagem registrada.</p>
                    <?php endif; ?>
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
                                <div id="exibicao-<?= $cmd['id'] ?>">
                                    <p><strong>Comando:</strong> <span id="total-commands"><?= htmlspecialchars($cmd['comando']) ?></span></p>
                                    <p><strong>Descrição:</strong> <span id="commands-today"><?= nl2br(htmlspecialchars($cmd['descricao'])) ?></span></p>
                                    <p><strong>Categoria:</strong> <span id="popular-command"><?= htmlspecialchars($cmd['categoria']) ?></span></p>
                                    <p><strong>Exemplo:</strong> <span id="popular-command"><?= htmlspecialchars($cmd['exemplo']) ?></span></p>
                                    <p><strong>Criado por:</strong> <span id="popular-command"><?= htmlspecialchars($cmd['autor']) ?></span></p>
                                    <p class="atalho">
                                        <a href="../edit.php?id=<?= $cmd['id'] ?>" onclick="mostrarFormulario(<?= $cmd['id'] ?>); return false;"><i class="fas fa-pen"></i></a>
                                        <a href="../delete.php?id=<?= $cmd['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')"><i class="fas fa-trash"></i></a>
                                    </p>
                                </div>
                                <form id="form-<?= $cmd['id'] ?>" action="../edit.php" method="post" style="display: none;">
                                    <input type="hidden" name="id" value="<?= $cmd['id'] ?>">
                                    <label>Comando: <input type="text" name="comando" value="<?= htmlspecialchars($cmd['comando']) ?>"></label><br>
                                    <label>Descrição: <input type="text" name="descricao" value="<?= htmlspecialchars($cmd['descricao']) ?>"></label><br>
                                    <label>Categoria: <input type="text" name="categoria" value="<?= htmlspecialchars($cmd['categoria']) ?>"></label><br>
                                    <label>Exemplo: <input type="text" name="exemplo" value="<?= htmlspecialchars($cmd['exemplo']) ?>"></label><br>
                                    <button type="submit" class="btn btn-sm btn-success">Salvar</button>
                                    <button type="button" onclick="cancelarFormulario(<?= $cmd['id'] ?>)" class="btn btn-sm btn-secondary">Cancelar</button>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhum comando personalizado cadastrado.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <script src="../../public/src/script/script.js"></script>
    <script>
        function mostrarFormulario(id){
            document.getElementById('exibicao-' + id).style.display = 'none';
            document.getElementById('form-' + id).style.display = 'block';
        }
        function cancelarFormulario(id){
            document.getElementById('form-' + id).style.display = 'none';
            document.getElementById('exibicao-' + id).style.display = 'block';
        }
    </script>
</body>
</html>