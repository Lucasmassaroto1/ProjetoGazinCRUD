<link rel="stylesheet" href="<?=$base_url?>public/assets/style/filtro.css">
<link rel="stylesheet" href="<?=$base_url?>public/assets/style/cards.css">
<link rel="stylesheet" href="<?=$base_url?>public/assets/style/embed.css">

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
                        <form id="formAdicionar" action="../component/create.php" method="post" style="display: none;">
                            <input type="text" name="comando" class="inputwelcome" placeholder="Comando" required><br><br>
                            <input type="text" name="descricao" class="inputwelcome" placeholder="Descrição" required><br><br>
                            <input type="text" name="categoria" class="inputwelcome" placeholder="Categoria" required><br><br>
                            <input type="text" name="exemplo" class="inputwelcome" placeholder="Exemplo de uso"><br><br>
                            <button type="submit" class="btn btnhover"><i class="fas fa-floppy-disk"></i> Salvar</button>
                            <button type="button" onclick="cancelarFormularioAdicionar()" class="btn btnhover"><i class="fas fa-xmark"></i> Cancelar</button>
                        </form>
                        <button onclick="mostrarFormularioAdicionar()" class="btn btnhover"><i class="fas fa-plus"></i> Novo Comando</button>   
                        <div id="lista-comandos"></div>
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
                                <button type="submit" class="btn btnhover"><i class="fas fa-floppy-disk"></i> Salvar Prefixo</button>
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
                                <button type="submit" class="btn btnhover"><i class="fas fa-floppy-disk"></i> Salvar Mensagem</button>
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
        <?php 
            require_once '../../config/conexao.php';
            $conexao = (new Conexao())->conectar();

            $stmtCategorias = $conexao->query("SELECT DISTINCT categoria FROM conteudo ORDER BY categoria ASC");
            $categoriasUnicas = $stmtCategorias->fetchAll(PDO::FETCH_COLUMN);
        ?>
        <div class="filter-container" style="margin-bottom: 1rem;">
            <label for="filtro-categoria"><strong>Filtrar por categoria:</strong></label>
            <select id="filtro-categoria" onchange="filtrarPorCategoria()">
                <option value="">Todos</option>
                <?php foreach ($categoriasUnicas as $categoria): ?>
                    <option value="<?= strtolower(preg_replace('/\s+/', '', $categoria)) ?>">
                        <?= htmlspecialchars($categoria) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="activity-list" id="listar-comandos-detalhes"></div>
    </div>
</div>
<script src="<?=$base_url?>public/assets/script/filtro.js"></script>
<script src="<?=$base_url?>public/assets/script/lista_pagina.js"></script>
<script>
    function mostrarFormulario(id){
        document.getElementById('exibicao-' + id).style.display = 'none';
        document.getElementById('form-' + id).style.display = 'block';
    }
    function cancelarFormulario(id){
        document.getElementById('form-' + id).style.display = 'none';
        document.getElementById('exibicao-' + id).style.display = 'block';
    }
    
    function mostrarFormularioAdicionar(){
        document.getElementById('formAdicionar').style.display = 'block';      
    }
    function cancelarFormularioAdicionar(){
        document.getElementById('formAdicionar').style.display = 'none';
    }
</script>