DELIMITER $$

CREATE TRIGGER usuario_inventario 
AFTER INSERT ON usuarios
FOR EACH ROW 
BEGIN
	insert into tarefas.inventarios(idUsuario) values (new.idUsuario);

END$$