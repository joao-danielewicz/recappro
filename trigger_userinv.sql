DELIMITER $$

CREATE TRIGGER usuario_inventario 
AFTER INSERT ON usuarios
FOR EACH ROW 
BEGIN
	insert into recappro.inventarios(idUsuario) values (new.idUsuario);

END$$
