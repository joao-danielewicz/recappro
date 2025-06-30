drop database if exists recappro;
create database recappro;
use recappro;

create table usuarios (
	idUsuario int not null auto_increment primary key,
    nome text not null,
    email text not null,
    dataNascimento date not null,
    telefone text not null,
    isAdmin int not null default 0,
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
    constraint fk_id_usuario_inventario foreign key(idUsuario) references usuarios(idUsuario)
);

create table itensInventario(
	idItem int not null,
    idInventario int not null,
    primary key(idItem, idInventario),
    constraint fk_id_item foreign key(idItem) references itensCosmeticos(idItem),
    constraint fk_id_inventario foreign key(idInventario) references inventarios(idInventario)
);


create table cursos (
	idCurso int not null auto_increment primary key,
    nome text not null,
    areaConhecimento text not null,
    dataAdicao datetime not null default current_timestamp,
    quantidadeNovasTarefas int not null default 10,
    idUsuario int not null,
    constraint fk_id_usuario foreign key(idUsuario) references usuarios(idUsuario) on delete cascade
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