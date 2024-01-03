Llenado tabla RESTRICCIONES
Fecha: 20-10-2023
Autor: Fernando García E.

Columna       Descripción
=======================================================================================================================================================
ID            número correlativo único
CLAVE         valor del documento de identificación que es la causa de la restricción
VALOR         rut u otro n° de documento que queda restringido de acceder
ENTIDAD       tipo de documento de identificación (rut a futuro pasaporte)
FEC_DESDE     fecha de inicio de la restricción
FEC_HASTA     si es null la restricción esta vigente, un valor define la fecha hasta que estaba vigente la restricción de acceso
FAMILIA_CLAVE el tipo de documento colocado en columna CLAVE, puede sedr RUT o PASAPORTE (este último valor pensado para implementar en el futuro)



