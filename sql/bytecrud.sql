Create database bytecrud;

create table comandos(
    id int not null primary key auto_increment,
    nome varchar(100) not null,
    descricao_cmd text not null,
    tipo varchar(50) not null,
    criado_em datetime default current_timestamp
);
create table usuario(
    id int not null primary key auto_increment,
    nome varchar(100) not null,
    email varchar(100) unique,
    senha varchar(255)
);
CREATE TABLE conteudo(
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);