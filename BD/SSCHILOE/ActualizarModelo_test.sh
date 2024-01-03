#!/bin/bash

sqlplus $1/$2@$3 << EOF>./resultados.log
SET ECHO ON
@@./Alter_Tabla_Personas.sql
@@./Alter_Tabla_Marcas.sql
EOF
