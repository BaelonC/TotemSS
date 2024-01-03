PROMPT AGREGAR ITEM DE MENU TOTEM_SSCHILOE;

DECLARE
    id_menu number(10);
    MAX_ID_PERFIL_GD NUMBER (38);
    id_menu_proyecto NUMBER(38);
    PROYECTO_GD_ID NUMBER(38);
    max_rel_perfil_menu NUMBER(38);
    
BEGIN
    select max(id)+1
    INTO id_menu
    from gestion_direccion.menu_gd;
    
    INSERT INTO GESTION_DIRECCION.MENU_GD (ID, NAME, PARENT, TEXTO, LINK, TARGET, ORDEN, PROYECTO_GD_ID, NUM_MENU) 
    VALUES (
    id_menu, 
    'totem_SSCHILOE', 
    'administracion', 
    'TOTEM SSCHILOE', 
    'gestion/totem/public/auth/sschiloe', 
    'Contenido', 
    '10', 
    '1', 
    '1');
    commit;    
EXCEPTION
    WHEN OTHERS THEN
    ROLLBACK;
END;
/
SHOW ERRORS
