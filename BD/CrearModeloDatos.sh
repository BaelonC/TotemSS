#!/bin/bash

sqlplus $1/$2@$3 << EOF>./resultados.log
@@./Modelo_01/Generado-20230425143642.sql
@@./Modelo_01/AggregarOpcionesMenuPanel.sql
@@./Modelo_01/CrearPerfilesQuellon.sql
@@./Modelo_01/CrearPerfilesAncud.sql
EOF
