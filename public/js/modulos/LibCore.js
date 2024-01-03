/* 
 * Esta versión es un desarrollo propio para proyecto totem
 */
 var _UrlBase = '';
 var _host = '';

//Wrapped para la función que implementa llamadas Ajax en Jquerie
function AjaxCall(url, datos, type, DataType) {
    console.log('LibCore.js => AjaxCall');
    console.log(datos);
        return $.ajax({
            url: url,
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            type: type ? type : 'GET',
            data: datos,
            datatype: DataType ? DataType : 'html',
            contentType: 'application/json'            
        });
    }
    
function fn_validar_rut(rut){
   console.log('LibCore.js => fn_validar_rut');   
   var digitos= [2,3,4,5,6,7,2,3];   
   var largo=0;
   var valor_intermedio=0;
   var pre_digito=0; 
           
   largo = rut.length;
   
   console.log(rut.substring(largo-1,1));
  
   if (largo === 0 && largo>10){
       return false;
   }else if (rut.substring(largo-1-1,largo-1)!=="-"){   
       return false;
   }else{
       var dv =rut.substring(largo-1,largo);
       var numero_rut = rut.substring(0,largo-1-1);
   }
   largo = numero_rut.length;
   for (i=(largo -1); i>=0; i--){
       c = numero_rut.substring(i,i+1);
       cc = parseInt(c);
       if (isNaN(cc)) return false;
          valor_intermedio=valor_intermedio+cc*digitos[largo-i-1];
   }
   pre_digito = 11 - (valor_intermedio%11);
   if (pre_digito ===11)
       dig_esperado = "0";
   else if(pre_digito===10)
       dig_esperado = "k";
   else
       dig_esperado= pre_digito.toString();
   
   if (dig_esperado === dv)
       return true;
   else
       return false;
   
   return true;
}    

export{_UrlBase, _host, AjaxCall, fn_validar_rut};