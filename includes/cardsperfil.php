<div class="grid-cards">
    <div class="card-status">
        <div class="card-header">
            <i class="fas fa-user"></i>
            <h2>Configurações do perfil</h2>
        </div>
        <div class="card-body">
            <?= $mensagem ?>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-content">
                        <form method="post" enctype="multipart/form-data" action="../component/fotoperfil.php">
                            <label>Nome:</label><br>
                            <input type="text" name="nome" class="inputwelcome" value="<?= htmlspecialchars($_SESSION['usuario_nome']) ?>"><br><br>
                            <label>Email:</label><br>
                            <input type="email" name="email" class="inputwelcome" value="<?= htmlspecialchars($user['email']) ?>"><br><br>
                            <label>Foto de perfil:</label><br>
                            <input type="file" name="foto" id="">
                            <button type="submit" class="btn btnhover">Salvar Alterações</button>
                        </form>
                        <button onclick="window.location.href='../trocasenha.php'" type="button" class="btn btnhover"><i class="fas fa-key"></i> Alterar Senha</button>
                        <button onclick="window.location.href='../component/delete_perfil.php'" type="button" class="btn btn-danger"><i class="fas fa-trash"></i> Deletar Usuário</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>