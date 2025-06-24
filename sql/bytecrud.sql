Create database bytecrud;
USE bytecrud;

CREATE TABLE usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo VARCHAR(20) DEFAULT 'comum'
);

INSERT INTO usuarios (id, usuario, senha, tipo)
VALUES (1, 'admin', SHA2('admin123', 256), 'admin');

ALTER TABLE usuarios ADD COLUMN token_recuperacao VARCHAR(255) NULL;
ALTER TABLE usuarios ADD COLUMN token_expiracao DATETIME NULL;
ALTER TABLE usuarios ADD COLUMN email VARCHAR(255) NOT NULL;

DROP TABLE IF EXISTS conteudo;

CREATE TABLE conteudo(
    id INT AUTO_INCREMENT PRIMARY KEY,
    comando VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    exemplo VARCHAR(255),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    criado_por INT NOT NULL,
    FOREIGN KEY (criado_por) REFERENCES usuarios(id)
);

/* CREATE TABLE prefixos( --TABELA PREFIXO POR SERVIDOR (USAR FUTURAMENTE)
    id INT AUTO_INCREMENT PRIMARY KEY,
    guild_id VARCHAR(20) NOT NULL UNIQUE,
    prefixo_customizado VARCHAR(5) DEFAULT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
 */

CREATE TABLE prefixos( --TABELA PREFIXO POR USUARIO (USANDO ATUALMENTE)
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
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
)
ALTER TABLE welcome ADD COLUMN footer TEXT;

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