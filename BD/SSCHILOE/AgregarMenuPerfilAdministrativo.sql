PROMPT REGISTRAR NUEVO MENU TOTEM_SSCHILOE;

DECLARE
          
    CURSOR c_idperfiles IS
        SELECT 
            DISTINCT(perfil_id)
        FROM BIBLIOTECA_VIRTUAL.usuario_panel
        INNER JOIN BIBLIOTECA_VIRTUAL.pertenencia_usuario
        ON usuario_panel.id = pertenencia_usuario.id_usuario
        INNER JOIN GESTION_DIRECCION.perfil_gd perf
        ON usuario_panel.perfil_id = perf.id
        WHERE tipo_dependencia IN ('SUB', 'DEP', 'DIR')
        AND perf.id = 50;
   
    TYPE t_idperfiles_type 
       IS TABLE OF BIBLIOTECA_VIRTUAL.usuario_panel.perfil_id%TYPE;
    
     t_idperfiles_ids t_idperfiles_type := t_idperfiles_type();
    
    MAX_ID_MENU  NUMBER(20);
    MAX_ID_PERFIL GESTION_DIRECCION.MENU_GD.ID%TYPE;
    
BEGIN   
    
    FOR r_idperfil IN c_idperfiles
    LOOP
        t_idperfiles_ids.EXTEND;
        t_idperfiles_ids(t_idperfiles_ids.LAST) := r_idperfil.perfil_id;
    END LOOP;
    
    
    --SELECT MAX(ID)
    --INTO MAX_ID_MENU
    --FROM ALIMENTACION.perfiles_test;
        
    SELECT MAX(ID)
    INTO MAX_ID_MENU
    FROM GESTION_DIRECCION.perfil_menu_gd;
    
    SELECT MAX(ID)
    INTO MAX_ID_PERFIL
    FROM GESTION_DIRECCION.MENU_GD;
    
    
    FOR l_index IN t_idperfiles_ids.FIRST..t_idperfiles_ids.LAST
    LOOP
    max_id_menu := max_id_menu + 1;
    
        insert INTO GESTION_DIRECCION.perfil_menu_gd (ID, perfil_gd_id, menu_gd_id, proyecto_gd_id)
        VALUES
        (
            max_id_menu,
            t_idperfiles_ids(l_index),
            MAX_ID_PERFIL,
            1
        );
    END LOOP;
    commit;
END;
/
SHOW ERRORS
