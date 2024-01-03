#!/bin/bash
export NLS_LANG=AMERICAN_AMERICA.AL32UTF8

sqlplus $1/$2@$3 << EOF>./resultados.log
SET ECHO ON
@@./Agregar_item_menu_totem_sschiloe.sql
@@./AgregarMenuPerfilAdministrativo.sql
@@./Crear_Tabla_Restricciones.sql
@@./Alter_Tabla_Personas.sql
@@./Alter_Tabla_Marcas.sql
@@./Insert_destinos.sql
@@./operaciones.sql
@@./operaciones2.sql
EOF
