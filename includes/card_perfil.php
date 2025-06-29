<link rel="stylesheet" href="<?= $base_url ?>public/assets/style/inputperfil.css">
<link rel="stylesheet" href="<?= $base_url ?>public/assets/style/cards.css">
<link rel="stylesheet" href="<?= $base_url ?>public/assets/style/embed.css">

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
                                
                                <!-- ================ MODAL CORTE DE FOTOS ================ -->
                                <div id="modal-overlay" style="display: none;"></div>
                                <div id="cropper-modal" style="display: none;">
                                    <div id="cropper-content">
                                        <span id="close-modal">&times;</span>
                                        <img id="cropper-image" style="max-width: 100%; max-height: 400px;">
                                        <button type="button" class="btn btnhover" onclick="recortarImagem()">
                                            <i class="fas fa-scissors"></i> Recortar
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="cropped_image" id="cropped_image_input">
                                <!-- <img id="preview" style="margin-top: 10px; max-width: 150px;"> VERIFICAR SE É IMPORTANTE -->
                                
                                <!-- ================ FIM MODAL RECORTE DE FOTO ================ -->
                                
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

                    <!-- ============== PERFIL ============== -->
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
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let cropper;
function loadPreview(input){
    const file = input.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            const image = document.getElementById('cropper-image');
            image.src = e.target.result;

            // Mostra o modal
            document.getElementById('modal-overlay').style.display = 'block';
            document.getElementById('cropper-modal').style.display = 'block';

            // Destroi o anterior se existir
            if(cropper) cropper.destroy();

            // Cria o novo cropper
            cropper = new Cropper(image,{
                aspectRatio: 1,
                viewMode: 1,
                movable: true,
                zoomable: true,
                rotatable: false,
                scalable: false,
            });
        };
        reader.readAsDataURL(file);
    }
}

function recortarImagem(){
    const canvas = cropper.getCroppedCanvas({
        width: 300,
        height: 300,
    });

    document.getElementById('preview').src = canvas.toDataURL();
    document.getElementById('cropped_image_input').value = canvas.toDataURL();
    fecharModal();
}

function fecharModal(){
    document.getElementById('modal-overlay').style.display = 'none';
    document.getElementById('cropper-modal').style.display = 'none';
    if (cropper) cropper.destroy();
}

// Botão de fechar
document.getElementById('close-modal').addEventListener('click', fecharModal);
</script>