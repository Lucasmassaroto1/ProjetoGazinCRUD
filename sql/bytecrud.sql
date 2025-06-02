Create database bytecrud;

create table comandos(
    id int not null primary key auto_increment,
    nome varchar(100) not null,
    descricao_cmd text not null,
    tipo varchar(50) not null,
    criado_em datetime default current_timestamp
);
/* create table usuario(
    id int not null primary key auto_increment,
    nome varchar(100) not null,
    email varchar(100) unique,
    senha varchar(255)  NÂO USAR ESTE E SIM O DE BAIXO
); */
CREATE TABLE usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL
);
INSERT INTO usuarios (usuario, senha)
VALUES ('admin', SHA2('admin123', 256));

/* CREATE TABLE conteudo(
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); */

DROP TABLE IF EXISTS conteudo;

CREATE TABLE conteudo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    comando VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    exemplo VARCHAR(255),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);