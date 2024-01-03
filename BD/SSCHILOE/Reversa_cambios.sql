DELETE from GESTION_DIRECCION.perfil_menu_gd where menu_gd_id = 843;
DELETE FROM GESTION_DIRECCION.MENU_GD WHERE ID = 843;
delete from totem.destino where observacion = 'SSCHILOE';
truncate table "TOTEM"."PERSONAS" drop storage;

drop table totem.restricciones;
ALTER TABLE totem.personas MODIFY APELLIDO_M VARCHAR2(30 CHAR) NOT NULL;
ALTER TABLE totem.marcas MODIFY APELLIDO_M VARCHAR2(30 CHAR)  NOT NULL;