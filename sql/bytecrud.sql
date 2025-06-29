----------------------------------------------------------------------------
------------------------------ CRIA DATABASE -------------------------------
----------------------------------------------------------------------------

Create database bytecrud;
USE bytecrud;

----------------------------------------------------------------------------
------------------------------ CRIA USUARIOS -------------------------------
----------------------------------------------------------------------------

CREATE TABLE usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo VARCHAR(20) DEFAULT 'comum',
    token_recuperacao VARCHAR(255) NULL,
    token_expiracao DATETIME NULL,
    email VARCHAR(255) NOT NULL,
    foto_perfil VARCHAR(255) NULL
);
INSERT INTO usuarios (id, usuario, senha, tipo) VALUES (1, 'admin', '$2y$10$rs4VAaJXTfJKSJm8Xrrb..2uiUqMLabo.g9o2V0FMyiy.WbTvo2na', 'admin');

----------------------------------------------------------------------------
------------------------------ CRIA CONTEUDO -------------------------------
----------------------------------------------------------------------------

DROP TABLE IF EXISTS conteudo;

CREATE TABLE conteudo(
    id INT AUTO_INCREMENT PRIMARY KEY,
    comando VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    exemplo VARCHAR(255),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    criado_por INT NOT NULL,
    FOREIGN KEY (criado_por) REFERENCES usuarios(id) ON DELETE CASCADE
);

----------------------------------------------------------------------------
------------------------------ CRIA PREFIXOS -------------------------------
----------------------------------------------------------------------------

CREATE TABLE prefixos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL UNIQUE,
    prefixo_customizado VARCHAR(5) DEFAULT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

----------------------------------------------------------------------------
------------------------------ CRIA WELCOME --------------------------------
----------------------------------------------------------------------------

CREATE TABLE welcome(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo TEXT NOT NULL,
    mensagem TEXT NOT NULL,
    imagem TEXT,
    footer TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);
ALTER TABLE welcome ADD COLUMN footer TEXT;

----------------------------------------------------------------------------
------------------------------ CRIA MUSICA ---------------------------------
----------------------------------------------------------------------------

CREATE TABLE musica(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo TEXT NOT NULL,
    autor TEXT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);
ALTER TABLE musica ADD COLUMN id_status INT;
ALTER TABLE musica ADD CONSTRAINT fk_status FOREIGN KEY (id_status) REFERENCES status(id);

CREATE TABLE status(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome TEXT NOT NULL
);

insert into status(nome)values('Andamento');
insert into status(nome)values('Em espera');
insert into status(nome)values('Tocado');

----------------------------------------------------------------------------
------------------------------ CRIA CONFIGURAÇÕES --------------------------
----------------------------------------------------------------------------

CREATE TABLE configuracoes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    volume INT DEFAULT 50
);

----------------------------------------------------------------------------
------------------------------ CRIA STATUS DO BOT --------------------------
----------------------------------------------------------------------------

CREATE TABLE status_bot(
    id INT PRIMARY KEY AUTO_INCREMENT,
    status VARCHAR(10) NOT NULL
);
INSERT INTO status_bot (status) VALUES ('online');
ALTER TABLE status_bot ADD COLUMN hora DATETIME NULL;

----------------------------------------------------------------------------
------------------------------ BANCO ANTIGO --------------------------------
----------------------------------------------------------------------------

/* Create database bytecrud;
USE bytecrud;

CREATE TABLE usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo VARCHAR(20) DEFAULT 'comum'
);

INSERT INTO usuarios (id, usuario, senha, tipo)
VALUES (1, 'admin', '$2y$10$rs4VAaJXTfJKSJm8Xrrb..2uiUqMLabo.g9o2V0FMyiy.WbTvo2na', 'admin');
-- INSERT INTO usuarios (id, usuario, senha, tipo) VALUES (1, 'admin', SHA2('admin123', 256), 'admin');

ALTER TABLE usuarios ADD COLUMN token_recuperacao VARCHAR(255) NULL;
ALTER TABLE usuarios ADD COLUMN token_expiracao DATETIME NULL;
ALTER TABLE usuarios ADD COLUMN email VARCHAR(255) NOT NULL;
ALTER TABLE usuarios ADD COLUMN foto_perfil VARCHAR(255) NULL;

DROP TABLE IF EXISTS conteudo;

CREATE TABLE conteudo(
    id INT AUTO_INCREMENT PRIMARY KEY,
    comando VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    exemplo VARCHAR(255),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    criado_por INT NOT NULL,
    FOREIGN KEY (criado_por) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE prefixos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL UNIQUE,
    prefixo_customizado VARCHAR(5) DEFAULT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE welcome(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo TEXT NOT NULL,
    mensagem TEXT NOT NULL,
    imagem TEXT,
    footer TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE musica(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo TEXT NOT NULL,
    autor TEXT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);
ALTER TABLE musica ADD COLUMN id_status INT;
ALTER TABLE musica ADD CONSTRAINT fk_status FOREIGN KEY (id_status) REFERENCES status(id);

CREATE TABLE status(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome TEXT NOT NULL
);
insert into status(nome)values('Andamento');
insert into status(nome)values('Em espera');
insert into status(nome)values('Tocado');

CREATE TABLE configuracoes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    volume INT DEFAULT 50
);

CREATE TABLE status_bot(
    id INT PRIMARY KEY AUTO_INCREMENT,
    status VARCHAR(10) NOT NULL
);
INSERT INTO status_bot (status) VALUES ('online');
ALTER TABLE status_bot ADD COLUMN hora DATETIME NULL;
 */