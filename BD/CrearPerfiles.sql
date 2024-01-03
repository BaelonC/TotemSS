DECLARE

    TYPE refcursor IS REF CURSOR;
    TYPE registro IS RECORD(
       id NUMBER
	  ,menu_gd_id NUMBER
	  ,perfil_gd_id NUMBER
	  ,proyecto_gd_id NUMBER
    );
    
    ID_USUARIO NUMBER(38);
    ID_PERSONA NUMBER(38);
    ID_PERFIL NUMBER(38);
    DESCRIPCION_PERFIL VARCHAR2(1000);
    ACTIVO VARCHAR2(1);
    USUARIO_MODIFICA  NUMBER(10);
    ESTABLECIMIENTO_ID NUMBER(10);
    FECHA_MODIFICA DATE;
    MAX_ID_PERFIL_GD NUMBER (38);
    max_rel_perfil_menu NUMBER(38);
    nuevo_perfil NUMBER(10);
    salida refcursor;  
    v_registro registro;
    descrip_nuevo_perfil GESTION_DIRECCION.perfil_gd.descripcion%TYPE;
    
BEGIN
    ACTIVO:= 'S';
    USUARIO_MODIFICA := 1;
    ESTABLECIMIENTO_ID :=197;
    nuevo_perfil:= 100;
    descrip_nuevo_perfil:= 'JEFE_INFORMATICA_QUELLON';
    
    --obtenemos datos del usuario 
    SELECT ID, PERSONAS_ID,PERFIL_ID
    INTO ID_USUARIO,ID_PERSONA,ID_PERFIL
    FROM biblioteca_virtual.usuario_panel 
    WHERE UPPER(correo_electronico) = UPPER('raul.millaldeo@redsalud.gov.cl');
    
    SSCHILOE_DBA.registrar_log('paso 1',null,null);
    
    --id = 3
    --personas_id = 3
    --perfil_id = 52
    
    --select * from biblioteca_virtual.usuario_panel where upper(usuario) = upper('raul.millaldeo');
    
    --select * from  refcentral.personas where id = 3;
    
    --obtenemos datos del perfil del usuario actual
    SELECT DESCRIPCION,ACTIVO,USUARIO_ID_MOD,FECHA_MOD,ESTABLECIMIENTO_ID 
    INTO DESCRIPCION_PERFIL, ACTIVO, USUARIO_MODIFICA, FECHA_MODIFICA, ESTABLECIMIENTO_ID
    FROM GESTION_DIRECCION.perfil_gd 
    WHERE id = ID_PERFIL;
    
    SSCHILOE_DBA.registrar_log('paso 2',null,null);
    
    --obtenemos el siguiente identificador libre para crear un nuevo perfil
    SELECT MAX(id)
    INTO MAX_ID_PERFIL_GD
    FROM GESTION_DIRECCION.perfil_gd;
    
    SSCHILOE_DBA.registrar_log('paso 3',null,null);
    MAX_ID_PERFIL_GD := MAX_ID_PERFIL_GD +1;
    
    SSCHILOE_DBA.registrar_log('maximo = ' || TO_CHAR(MAX_ID_PERFIL_GD),null,null);
    
    --consultamos todos los item de menú a los que tiene acceso el perfil del usuarioactual
    OPEN salida FOR
         SELECT id, menu_gd_id, perfil_gd_id, proyecto_gd_id 
         FROM GESTION_DIRECCION.perfil_menu_gd 
         WHERE perfil_gd_id = 52;
    
    --insertar nuevo perfil en GESTION_DIRECCION.perfil_gd
    SSCHILOE_DBA.registrar_log('PASO 4 CURSOR ABIERTO',null,null);
    
    --Creamos nuevo perfil para el usuario
    INSERT INTO GESTION_DIRECCION.perfil_gd(ID,DESCRIPCION,ACTIVO,USUARIO_ID_MOD,FECHA_MOD,ESTABLECIMIENTO_ID) 
    VALUES
    ( 
       MAX_ID_PERFIL_GD,
       descrip_nuevo_perfil,
       'S',
       1,
       SYSDATE,
       197
    );
       
    SSCHILOE_DBA.registrar_log('paso 5: creado nuevo perfil',null,null);
       
    --obtenemos el siguiente id libre en tabla de relación item de menús con perfiles de usuario   
    SELECT MAX(ID) 
    INTO max_rel_perfil_menu
    FROM GESTION_DIRECCION.perfil_menu_gd;  
    
    max_rel_perfil_menu:= max_rel_perfil_menu + 1;
    
    SSCHILOE_DBA.registrar_log('paso 6: siguient eregistro en perfil_menu_gd = ' || TO_CHAR(max_rel_perfil_menu),null,null);
	   
    --iteramos sobre el cursos con los item de menú del perfil actual del usuario   
    LOOP
        FETCH salida INTO v_registro;
        EXIT WHEN salida%NOTFOUND;
    	  
    	  SSCHILOE_DBA.registrar_log('LOOP PASO 7: procesando cursor: ' || TO_CHAR(v_registro.menu_gd_id),null,null);
    	  
        --en base a los perfiles actuales dell usuario y lo item de menú a los que tiene acceso creamos nuevas entradas para el nuevo perfil del usuario  
        INSERT INTO GESTION_DIRECCION.perfil_menu_gd (id,menu_gd_id,perfil_gd_id,proyecto_gd_id) 
        VALUES
        (
         max_rel_perfil_menu	
    	,v_registro.menu_gd_id
    	,MAX_ID_PERFIL_GD
        ,v_registro.proyecto_gd_id
        );
    	  max_rel_perfil_menu:= max_rel_perfil_menu + 1;
    	  
    	  
    END LOOP;  
    CLOSE salida;
    
    --debemos cambiar el perfil del usuario al nuevo perfil creado
    
    
    SSCHILOE_DBA.registrar_log('fin ' || TO_CHAR(v_registro.menu_gd_id),null,null);
EXCEPTION
    WHEN OTHERS THEN
         SSCHILOE_DBA.registrar_log('se detecta error ',SUBSTR(SQLERRM,1,1024),SQLCODE);
         ROLLBACK;
END;
