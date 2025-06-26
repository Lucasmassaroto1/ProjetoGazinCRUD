<?php 
    require_once '../../config/auth.php';
    require_once '../../config/conexao.php';

    $conexao =(new Conexao())->conectar();

    $usuario_id = $_SESSION['usuario_id'];
    $usuario_tipo = $_SESSION['usuario_tipo'];

    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $usuario_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // ================ CONTEUDO (COMANDOS) ================
    $limite = 3;
    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $pagina = $pagina < 1 ? 1 : $pagina;
    $offset = ($pagina - 1) * $limite;
    
    if($usuario_tipo === 'admin'){
        $stmtTotal = $conexao->query("SELECT COUNT(*) AS total FROM conteudo");
        $total = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    }else{
        $stmtTotal = $conexao->prepare("SELECT COUNT(*) AS total FROM conteudo WHERE criado_por = ?");
        $stmtTotal->execute([$usuario_id]);
        $total = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    }

    $totalPaginas = ceil($total / $limite);
    $total_commands = $total;

    if($usuario_tipo === 'admin'){
        $stmt = $conexao->prepare("SELECT c.*, u.usuario AS autor FROM conteudo c JOIN usuarios u ON c.criado_por = u.id ORDER BY c.data_criacao DESC LIMIT :limite OFFSET :offset");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
    }else{
        $stmt = $conexao->prepare("SELECT c.*, u.usuario AS autor FROM conteudo c JOIN usuarios u ON c.criado_por = u.id WHERE c.criado_por = :usuario_id ORDER BY c.data_criacao DESC LIMIT :limite OFFSET :offset");
        $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ================ PREFIXO_PERSONALIZADO ================
    $usuario_id = $_SESSION['usuario_id'];
    $stmt = $conexao->prepare("SELECT prefixo_customizado FROM prefixos WHERE usuario_id = ?");
    $stmt->execute([$usuario_id]);
    $prefixo_atual = $stmt->fetchColumn();

    // ================ CONTEUDO CONTINUAÇÃO (COMANDOS 2) ================
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

    // ================ MENSAGEM DE BEM VINDO ================
    $stmtWelcome = $conexao->prepare("SELECT * FROM welcome WHERE usuario_id = ? ORDER BY id DESC LIMIT 1");
    $stmtWelcome->execute([$usuario_id]);
    $welcome = $stmtWelcome->fetch(PDO::FETCH_ASSOC);

    $mensagemEnviada = isset($_GET['mensagemEnviada']) && $_GET['mensagemEnviada'] == '1';
    if($mensagemEnviada){
        $welcomeInputs = [
            'titulo' => '',
            'mensagem' => '',
            'footer' => ''
        ];
    }else{
        $welcomeInputs = $welcome ?: ['titulo' => '', 'mensagem' => '', 'footer' => ''];
    }
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
    <!-- ======== ELEMENTOS SEPARADOS ======== -->
    <link rel="stylesheet" href="../../public/src/style/dash.css">
    <link rel="stylesheet" href="../../public/src/style/filtro.css">
    <link rel="stylesheet" href="../../public/src/style/cards.css">
    <link rel="stylesheet" href="../../public/src/style/embed.css">
    <title>ByteCode Comandos</title>
</head>
<body>
    <?php $base_url = '../../'; $paginaAtual = 'comandos'; include '../../includes/menu.php'?>
    <main class="conteudo">
        <?php include '../../includes/header.php';?>
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
                                        <?php endforeach; ?>
                                            <button onclick="window.location.href='../create.php'" type="button" class="btn btnhover"><i class="fa-solid fa-plus"></i> Novo Comando</button>
                                <?php else: ?>
                                    <p>Crie um comando personalizado Aqui.</p>
                                    <button onclick="window.location.href='../create.php'" type="button" class="btn btnhover">+ Novo Comando</button>
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
                        <div class="activity-list">
                            <div class="activity-item">
                                <div class="activity-content">
                                    <form action="../component/valida_prefix.php" method="post">
                                        <p><strong>Prefixo Original:</strong> <span id="original-prefix" class="status-prefix">!</span></p>
                                        <p><strong>Prefixo Personalizado:</strong> <span id="custom-prefix" class="status-prefix"><?= htmlspecialchars($prefixo_atual ?? '-') ?></span></p>
                                        <p><input type="text" name="prefixo" id="input-prefix" class="inputwelcome" placeholder="Digite o prefixo" maxlength="1"></p>
                                        <button type="submit" class="btn btnhover">Salvar Prefixo</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if ($welcomeInputs): ?>
            <div class="grid-cards">
                <div class="card-status">
                    <div class="card-header">
                        <i class="fas fa-users"></i>
                        <h2>Welcome</h2>
                    </div>
                    <div class="card-body">
                        <div class="activity-list">
                            <div class="activity-item">
                                <div class="activity-content">
                                    <form action="../component/valida_welcome.php" method="post">
                                        <input type="text" name="titulo" class="inputwelcome" placeholder="Titulo" value="<?= $welcomeInputs['titulo'] ?? ''?>" required><br>
                                        <input type="text" name="mensagem" class="inputwelcome"  placeholder="Mensagem" value="<?= $welcomeInputs['mensagem'] ?? ''?>" required>
                                        <label style="color: var(--marcador-color);">Use: {user.mention} para marcar pelo cargo</label>
                                        <input type="text" name="footer" class="inputwelcome"  placeholder="footer" value="<?= $welcomeInputs['footer'] ?? ''?>" required><br>
                                        <button type="submit" class="btn btnhover"> Salvar Mensagem</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>

        <div class="card-status activity-log">
            <div class="card-header">
                <i class="fas fa-terminal"></i>
                <h2> Detalhes Comandos Personalizados</h2>
            </div>
            <div class="card-body">
            <div class="filter-container" style="margin-bottom: 1rem;">
                <label for="filtro-categoria"><strong>Filtrar por categoria:</strong></label>
                <select id="filtro-categoria" onchange="filtrarPorCategoria()">
                    <option value="">Todos</option>
                    <?php 
                        // Gera as categorias únicas
                        $categoriasUnicas = array_unique(array_column($dados, 'categoria'));
                        foreach ($categoriasUnicas as $categoria):?>
                            <option value="<?= strtolower(preg_replace('/\s+/', '', $categoria)) ?>"><?= htmlspecialchars($categoria) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
                <div class="activity-list">
                    <?php if ($dados): ?>
                        <?php foreach ($dados as $cmd): ?>
                        <div class="activity-item" data-categoria="<?= strtolower(preg_replace('/\s+/', '', $cmd['categoria'])) ?>">
                            <div class="activity-content">
                                <div id="exibicao-<?= $cmd['id'] ?>">
                                    <p><strong>Comando:</strong> <span id="total-commands"><?= htmlspecialchars($cmd['comando']) ?></span></p>
                                    <p><strong>Descrição:</strong> <span id="commands-today"><?= nl2br(htmlspecialchars($cmd['descricao'])) ?></span></p>
                                    <p><strong>Categoria:</strong> <span id="popular-command"><?= htmlspecialchars($cmd['categoria']) ?></span></p>
                                    <p><strong>Exemplo:</strong> <span id="popular-command"><?= htmlspecialchars($cmd['exemplo']) ?></span></p>
                                    <p><strong>Criado por:</strong> <span><?= htmlspecialchars($cmd['autor']) ?></span></p>
                                    <p class="atalho">
                                        <a href=".../component/edit.php"?id=<?= $cmd['id'] ?>" onclick="mostrarFormulario(<?= $cmd['id'] ?>); return false;"><i class="fas fa-pen"></i></a>
                                        <a href="../component/delete.php?id=<?= $cmd['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')"><i class="fas fa-trash"></i></a>
                                    </p>
                                </div>
                                <form id="form-<?= $cmd['id'] ?>" action="../component/edit.php" method="post" style="display: none;">
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
                    <?php if ($totalPaginas > 1): ?>
                        <div class="paginacao">
                            <?php if ($pagina > 1): ?>
                                <a class="btn" href="?pagina=<?= $pagina - 1 ?>">&laquo; Anterior</a>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                <a class="btn <?= ($i == $pagina) ? 'ativo' : '' ?>" href="?pagina=<?= $i ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                            <?php if ($pagina < $totalPaginas): ?>
                                <a class="btn" href="?pagina=<?= $pagina + 1 ?>">Próximo &raquo;</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <?php include '../../includes/footer.php'?>
    <script src="../../public/src/script/filtro.js"></script>
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