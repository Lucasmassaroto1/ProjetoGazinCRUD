<link rel="stylesheet" href="<?= $base_url ?>public/src/style/inputperfil.css">
<div class="alinhacard">
    <div class="grid-cards">
        <div class="card-status">
            <div class="card-header">
                <i class="fas fa-user"></i>
                <h2>Configurações do perfil</h2>
            </div>
            <div class="card-body">
                <?= $mensagem ?>
                <div class="activity-list" style="flex-direction: row;">
                    <div class="activity-item">
                        <div class="activity-content">
                            <form method="post" enctype="multipart/form-data" action="../component/fotoperfil.php">
                                <label>Nome:</label>
                                <input type="text" name="nome" class="inputwelcome" value="<?= htmlspecialchars($_SESSION['usuario_nome']) ?>"><br><br>
                                <label>Email:</label>
                                <input type="email" name="email" class="inputwelcome" value="<?= htmlspecialchars($user['email']) ?>"><br><br>
                                <div class="upload-area">
                                    <label>Foto de perfil:</label>
                                    <label for="foto" class="custom-upload-btn"><i class="fas fa-upload"></i> Adicionar imagem</label>
                                    <input type="file" name="foto" id="foto" accept="image/*" onchange="loadPreview(this)">
                                </div>
                                <div class="activity-item">
                                    <div class="activity-content">
                                        <form method="post" enctype="multipart/form-data" action="../component/fotoperfil.php">
                                            <button type="submit" class="btn btnhover"><i class="fas fa-floppy-disk"></i> Salvar</button>
                                            <button onclick="window.location.href='../trocasenha.php'" type="button" class="btn btnhover"><i class="fas fa-key"></i> Alterar Senha</button>
                                            <button type="submit" name="remover_foto" value="1" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Remover Foto</button>
                                            <button onclick="if(confirm('Tem certeza que deseja excluir seu perfil? Essa ação não pode ser desfeita.')){window.location.href='../component/delete_perfil.php';}" type="button" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Deletar Usuário</button>
                                        </form>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- ============== INICIO PERFIL ============== -->
                    <div class="card-status">
                        <div class="card-header">
                            <i class="fas fa-user"></i>
                            <h2>Perfil</h2>
                        </div>
                        <div class="card-body">
                            <div class="activity-list">
                                <div class="activity-item">
                                    <div class="activity-content">
                                        <div class="resultado-perfil">
                                            <?php if (!empty($user['foto_perfil'])): ?>
                                                    <img id="preview" class="resultado-image" src="<?= $base_url . 'public/uploads/' . $user['foto_perfil'] ?>" alt="Foto de perfil">
                                                <?php else: ?>
                                                <div id="preview" class="resultado-letra">
                                                    <?= strtoupper($_SESSION['usuario_nome'][0]) ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="resultado-nome">
                                                <?= strtoupper($_SESSION['usuario_nome']) ?>
                                            </div>
                                            <div class="resultado-nome">
                                                <?= htmlspecialchars($user['email']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============== FIM PERFIL ============== -->
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function loadPreview(input){
    const file = input.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            document.getElementById('preview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}
</script>