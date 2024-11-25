drop database if exists tarefas;
create database tarefas;
use tarefas;

create table usuarios (
	idUsuario int not null auto_increment primary key,
    nome text not null,
    email text not null,
    dataNascimento date not null,
    telefone text not null,
    qtdPontos int not null default 0,
    idFotoPerfil int not null default 0,
    senha varchar(64) not null
);

create table itensCosmeticos(
	idItem int not null auto_increment primary key,
    descricao text not null,
    tipo text not null,
    midia longblob not null
);

create table inventarios(
	idInventario int not null auto_increment primary key,
    idUsuario int not null,
    constraint fk_id_usuario_inventario foreign key(idUsuario) references usuarios(idUsuario) on delete cascade
);

create table itensInventario(
	idItem int not null,
    idInventario int not null,
    primary key(idItem, idInventario),
    constraint fk_id_item foreign key(idItem) references itensCosmeticos(idItem) on delete cascade,
    constraint fk_id_inventario foreign key(idInventario) references inventarios(idInventario) on delete cascade
);

create table feedbacks(
	idFeedback int not null auto_increment primary key,
    assunto text not null,
    texto text not null,
    idUsuario int not null,
    constraint fk_id_usuario_feedback foreign key(idUsuario) references usuarios(idUsuario)
);

create table cursos (
	idCurso int not null auto_increment primary key,
    nome text not null,
    areaConhecimento text not null,
    dataAdicao datetime not null default current_timestamp,
    quantidadeNovasTarefas int not null default 10,
    idUsuario int not null,
    constraint fk_id_usuario foreign key(idUsuario) references usuarios(idUsuario)
);

create table tarefas (
    idTarefa int not null auto_increment primary key,
    assunto varchar(100) not null,
    pergunta text not null,
    resposta text not null,
    midiaPergunta longblob null,
    midiaResposta longblob null,
    dataAdicao datetime default current_timestamp,
    dataProximoEstudo datetime null default current_timestamp,
    dataUltimoEstudo datetime null default current_timestamp,
    nivelEstudo int not null,
    idCurso int not null,
    constraint fk_id_curso foreign key(idcurso) references cursos(idCurso) on delete cascade
);

insert into usuarios(nome, email, senha, dataNascimento, telefone) values ('joao', 'joao@joao.com', 'f44d03a974b576b7bd08cadfe90da134ba4cff04cd59e1bb547c4eb39b77725f', 20040916, '49999653313');
insert into cursos (nome, areaConhecimento, idUsuario) values ('teste', 'teste', 1);
insert into cursos (nome, areaConhecimento, idUsuario) values ('outroteste', 'outroteste', 1);
insert into tarefas (assunto, pergunta, resposta, nivelestudo, idcurso) values ('teste', 'teste', 'teste', -1, 1);
insert into tarefas (assunto, pergunta, resposta, nivelestudo, idcurso) values ('outroteste', 'outroteste', 'outroteste', -1, 1);
insert into tarefas (assunto, pergunta, resposta, nivelestudo, idcurso) values ('maisoutroteste', 'maisoutroteste', 'maisoutroteste', 0, 6);

insert into usuarios(nome, email, senha, dataNascimento, telefone) values ('joao', 'joao', '52aa854c0120218c02dad358eb436f4a0e8a584d150c00cf36f2e590aed2a3dd', 20040916, '49999653313');
insert into cursos (nome, areaConhecimento, idUsuario) values ('outroteste', 'outroteste', 3);

select * from tarefas;
select * from usuarios;
select * from cursos;

select ic.midia as fotoPerfil from usuarios as u, itensCosmeticos as ic where u.idFotoPerfil = ic.idItem AND idUsuario = 2;

update usuarios set idFotoPerfil = 11 where idUsuario=2;


SELECT tarefas.* FROM tarefas INNER JOIN
                        cursos ON tarefas.idCurso = cursos.idCurso WHERE
                        tarefas.idCurso = 4 AND
                        cursos.idUsuario = 3 AND
                        (CAST(tarefas.dataProximoEstudo as DATE) = ('2024-11-24') OR
                        tarefas.nivelEstudo = 0);
                        
                        
select *
