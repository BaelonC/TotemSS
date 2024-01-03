#!/bin/bash

sqlplus $1/$2@$3 << EOF>./resultados.log
@@./Modelo_01/CrearEsquemaUsuario.sql
EOF
