use tarefas;

insert into usuarios(nome, email, senha, dataNascimento, telefone, isAdmin) values ('joao', 'joao@joao.com', 'f44d03a974b576b7bd08cadfe90da134ba4cff04cd59e1bb547c4eb39b77725f', 20040916, '49999653313', 1);
insert into cursos (nome, areaConhecimento, idUsuario) values ('teste', 'teste', 1);
insert into cursos (nome, areaConhecimento, idUsuario) values ('outroteste', 'outroteste', 1);
insert into tarefas (assunto, pergunta, resposta, nivelestudo, idcurso) values ('teste', 'teste', 'teste', -1, 1);
insert into tarefas (assunto, pergunta, resposta, nivelestudo, idcurso) values ('outroteste', 'outroteste', 'outroteste', -1, 1);
insert into tarefas (assunto, pergunta, resposta, nivelestudo, idcurso) values ('maisoutroteste', 'maisoutroteste', 'maisoutroteste', 0, 1);

insert into usuarios(nome, email, senha, dataNascimento, telefone, isAdmin) values ('joao', 'joao@joao', '68412c84de1c1aaf8878890e79d2c6410aa2151b15b995806d212660413261f1', 20040916, '49999653313', 1);
insert into itensInventario (idItem, idInventario) values (2, (SELECT idInventario FROM inventarios where inventarios.idUsuario=3));
select * from itensCosmeticos INNER JOIN itensInventario ON itensCosmeticos.idItem = itensInventario.idItem
							  INNER JOIN inventarios ON itensInventario.idInventario = inventarios.idInventario WHERE
                              idUsuario = 3;
select * from itensInventario;
select * from inventarios;

