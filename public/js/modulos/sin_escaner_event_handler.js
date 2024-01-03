/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */


import {AjaxCall} from './LibCore.js';
import {procesarGetDestinos} from './destino_event_handler.js';

function paisEstaSeleccionado(){
    
    console.log('sin_escaner_event_handler.js => paisEstaSeleccionado');
    
    var respta = false;
    var opais = document.getElementById('sin_escaner_lstpaises').value;
    if (opais !== 'País de Origen') {
        return true;
    }
    else{
        return false;    
    }    
}

function addchar(caracter){
    console.log('sin_escaner_event_handler.js => addchar');
    console.log('addchar '+ caracter);    
    
    if (paisEstaSeleccionado()) {
       var texto = document.getElementById('sin_escaner_valor_documento').value + caracter;
       document.getElementById('sin_escaner_valor_documento').value = texto;        
    }else{
       alert ('debe seleccionar un país');
    }

};

function delchar(){
    console.log('sin_escaner_event_handler.js => delchar');
    console.log('delchar');
    
    if (paisEstaSeleccionado()) {
       var tag = document.getElementById('sin_escaner_valor_documento');
       var texto = tag.value;
       tag.value = texto.substring(0,texto.length-1);    
   }else{
       alert ('debe seleccionar un país');
   }
};

function changeKeyboard(id_teclado){
        console.log('sin_escaner_event_handler.js => changeKeyboard');
        var inicio_ascii = 64;
        var tecla = null;
        var i = 0;        
        for (i=0; i<10; i++){
            tecla = document.getElementById('sin_escaner_tecla'+String(i));                    
            if (id_teclado === 0){
                tecla.innerText= String(i);
                tecla.innerHtml = '<button type="button">'+String(i)+'</button>';
                tecla.textContent = String(i);                
            }else{
                if (i===9) {
                   tecla.innerText= String.fromCharCode(45);
                   tecla.textContent = String.fromCharCode(45);
                   tecla.innerHtml = '<button type="button">'+String.fromCharCode(45)+'</button>';                                
                }else{
                   tecla.innerText= String.fromCharCode(inicio_ascii+id_teclado+3*i);
                   tecla.textContent = String.fromCharCode(inicio_ascii+id_teclado+3*i);
                   tecla.innerHtml = '<button type="button">'+String.fromCharCode(inicio_ascii+id_teclado+3*i)+'</button>';                
                }
            }        
            tecla.className = 'tecla'+String(i)+' btn btn-light';
    }
};

function ChangeTeclado(){
    console.log('sin_escaner_event_handler.js => ChangeTeclado');
    console.log('ChangeTeclado');    
    var tag = document.getElementById('sin_escaner_tipo_teclado');
    var valor = (parseInt(tag.value)+1)%4;
    tag.value = String(valor);
    changeKeyboard(valor);
};

function registroManual(urlBase){
    console.log('sin_escaner_event_handler.js => registroManual');
    console.log('registroManual');        
    
    console.log('valor docto='+document.getElementById('sin_escaner_valor_documento').value);
    console.log('valor paises='+document.getElementById('sin_escaner_lstpaises').value);
    console.log('valor Tipo de documento='+document.getElementById('sin_escaner_TipDocto').value);
    
    if (document.getElementById('sin_escaner_valor_documento').value!=='' && document.getElementById('sin_escaner_lstpaises').value !== 'País de Origen' && document.getElementById('sin_escaner_TipDocto') !== 'T. docto. identificación') {
        var datos_pre_json = [{             
                              'numero_identificacion': document.getElementById('sin_escaner_valor_documento').value,
                              'tipo_documento': document.getElementById('sin_escaner_TipDocto').value,
                              'pais':document.getElementById('sin_escaner_lstpaises').value,
                              'modo_ingreso':'manual'
                             }];    
        console.log(datos_pre_json);
        AjaxCall(urlBase+'/auth/getDestinos',JSON.stringify(datos_pre_json[0]), 'POST','JSON').done(function(response){
             console.log('llego respuesta desde GetDestinos');  
             var json_obj = $.parseJSON(response);
             console.log(json_obj);                  
//             if (json_obj['codigo']===0) {
//                $('#inicio').html('');
//                $('#inicio').append(json_obj['datos_html']);         
//                $('#tabs'  ).tabs();                
//            }else if (json_obj['codigo'] === 1) {
//                $('#otro_medio').html('');
//                $('#otro_medio').append(json_obj['datos_html']);         
//            }
            

             procesarGetDestinos(json_obj);
        });    
    }else{
        alert('Debe especifar País, tipo de documento de identificación y número del documento de identificación');
    }
};

function configurar_cedula_chilena(){
        console.log('sin_escaner_event_handler.js => configurar_cedula_chilena');
        console.log('evSelChile evento');
        var objeto = document.getElementById('sin_escaner_lstpaises');
        console.log('evSelChile lstpaises value = '+ objeto.value);
        if(objeto.value=== 'CL'){
          console.log('evSelChile Valor de oPaises es CL');  
          var oTipoDocumento = document.getElementById('sin_escaner_TipDocto');
          oTipoDocumento.value = 'CI';
        }else{
          console.log('evSelChile Valor de oPaises es CL');  
          var oTipoDocumento = document.getElementById('sin_escaner_TipDocto');
          oTipoDocumento.value = 'PASAPORTE';                    
        }

};


/**
 * filtrar_pais_tipo_documento
 */
function filtrar_pais_tipo_documento() {
    console.log('sin_escaner_event_handler.js => filtrar_pais_tipo_documento');
    console.log('filtrar_pais_tipo_documento');
    var otipdocto = document.getElementById('sin_escaner_TipDocto');
    var opais = document.getElementById('sin_escaner_lstpaises');
    if ((otipdocto.value === 'CI')) {        
        opais.value = 'CL';        
    }else{
        opais.value = 'AF';
    }    
    
}

export{addchar, delchar, ChangeTeclado, registroManual,configurar_cedula_chilena, filtrar_pais_tipo_documento };