Create database bytecrud;

CREATE TABLE usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL
);
INSERT INTO usuarios (usuario, senha)
VALUES ('admin', SHA2('admin123', 256));

DROP TABLE IF EXISTS conteudo;

CREATE TABLE conteudo(
    id INT AUTO_INCREMENT PRIMARY KEY,
    comando VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    exemplo VARCHAR(255),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE prefixos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    guild_id VARCHAR(20) NOT NULL UNIQUE,
    prefixo_customizado VARCHAR(5) DEFAULT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);