import pandas as pd
import numpy as np

ruta_base = '/home/fernando.garcia/workspace/apl/php/PruebasConcepto/totem/BD/SSCHILOE/'

personas = pd.read_csv(ruta_base+'RUT_Personas_Panel_20231020.csv', sep =',')
c = "'"
print(personas)
print(personas.dtypes)
personas = personas.dropna(subset=['RUT'])

personas ['TIPO_DOCUMENTO'] = 'CI'
personas ['ID'] = np.nan
personas ['PASAPORTE'] = np.nan
personas ['CODIGO_PAIS'] = 'CL'
personas['RUT'] = personas.RUT.astype(str)
personas['DV'] = personas.DV.astype(str)
personas['ID'] = personas.ID.astype(str)
personas['NOMBRE'] = personas.NOMBRE.astype(str)
personas['APELLIDO_P'] = personas.APELLIDO_P.astype(str)
personas['APELLIDO_M'] = personas.APELLIDO_M.astype(str)
personas['PASAPORTE'] = personas.PASAPORTE.astype(str)

print(personas)
print(personas.dtypes)

texto = 'INSERT INTO TOTEM.PERSONAS (RUT,DV,NOMBRE,APELLIDO_P, APELLIDO_M, TIPO_DOCUMENTO, ID, PASAPORTE,CODIGO_PAIS) VALUES ('
f = open(ruta_base + 'operaciones2.sql','a+')
total = personas.shape[0];
inicio = 184938+1
for item in range(len(personas)):
    rut = c+ personas.iloc[item]['RUT'] +c
    dv = c + personas.iloc[item]['DV'] + c
    nombre = c + personas.iloc[item]['NOMBRE'] + c
    apellido_p = c + personas.iloc[item]['APELLIDO_P'] + c
    apellido_m = c + personas.iloc[item]['APELLIDO_M'] + c
    fila=texto + rut + ',' + dv + ',' + nombre + ',' + apellido_p + ',' + apellido_m + ',' + c + 'CI' + c + ',' + c + str(item+inicio) + c + ',' + 'NULL'  ',' + c + 'CL' + c + ');\n'
    #operacion.append(fila)
    f.write(fila.upper())
    if (item + inicio)%1000 == 0:
       f.write('commit;\n') 
    print (f'avance = {item/total*100:2f}')
f.write('commit;\n')
f.close()    
