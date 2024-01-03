/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

import {updatePersona} from './completarDatosPersona_event_handler.js';
import {registrar_entrada,procesarGetDestinos} from './destino_event_handler.js';
import {AjaxCall} from './LibCore.js';

var _ActiveElement = null;

function completarDatosPersona_init(){
    console.log('Generales.js => completarDatosPersona_init() ');
    
    
    var obj = document.getElementById("completarDatosPersona_btn_safenombre");
    obj.addEventListener('click', (event) => {
        updatePersona(_UrlBase);
    },false);
    
    
    var obj = document.getElementById('completarDatosPersona_nom_persona');
    obj.addEventListener('focus', (event) => {
        _ActiveElement = document.getElementById('completarDatosPersona_nom_persona');
    },false);

    var obj = document.getElementById('completarDatosPersona_nom_apaterno');
    obj.addEventListener('focus', (event) => {
        _ActiveElement = document.getElementById('completarDatosPersona_nom_apaterno');
    },false);
    
    
    var obj = document.getElementById('completarDatosPersona_nom_amaterno');
    obj.addEventListener('focus', (event) => {
        _ActiveElement = document.getElementById('completarDatosPersona_nom_amaterno');
    },false);            
    
    let teclas = [
                   'q','w','e','r','t','y','u','i','o','p',
                   'a','s','d','f','g','h','j','k','l','ñ',
                   'z','x','c','v','b','n','m','subrayado','menos','apostrofe',
                   'espacio','DEL'
    ];
    
    let tespeciales = {"subrayado": "_",
                     "menos"    : "-",
                     "apostrofe": "'",
                     "espacio"  : " "
                    };
    
    console.log ("tespeciales:");
    console.log (tespeciales);
    console.log (tespeciales["espacio"]);
    
    
    
    teclas.forEach(function(element){
        console.log ('procesando ='+element)
        if(element !=='subrayado' && element !=='menos' && element !== 'apostrofe' && element !== 'DEL' && element !== 'espacio'){ 
           var otecla = document.getElementById('completarDatosPersona_tecla'+element); 
           otecla.addEventListener('click', (event) => {
            // el código debe decir para txt con el focus agregar el caracter almacenado en variable element
            _ActiveElement.value = _ActiveElement.value + element;
           },false);
        } else if (element !== 'DEL') {
           console.log('caso if (!== DEL:'+element);
           console.log('caso if (!== DEL:'+tespeciales[element]);
           var otecla = document.getElementById('completarDatosPersona_tecla'+element);  
           console.log('otecla:');
           console.log(otecla);
           otecla.addEventListener('click', (event) => {
            // el código debe decir para txt con el focus agregar el caracter almacenado en tespeciales[element]
            _ActiveElement.value = _ActiveElement.value + tespeciales[element];
           },false);           
        } else{
           var otecla = document.getElementById('completarDatosPersona_tecla'+element);   
           otecla.addEventListener('click', (event) => {
            // el código debe decir para txt con el focus quitar el último caracter
            if(_ActiveElement.value.length > 0){
               _ActiveElement.value = _ActiveElement.value.substring(0,_ActiveElement.value.length-1);
            }
           },false);                      
        }
    });
}

function destino_init(){

    console.log('Generales.js => destino_init() ');
    let obj = document.getElementById("destino_destinos");
    console.log('valor del objeto identificado');
    console.log(obj);
    obj.addEventListener('click', (event) => {
        var id = event.target.id;
        console.log('valor del identificador capturado:');
        console.log(id);
        if (id.includes('destino_P_')) {
            console.log('identificado filtrado para manejedor de evento =>' + id);
            var componentes = id.split('_');
            console.log('inicio valor del identificador a enviar al handler :');
            console.log(componentes);
            console.log('fin valor del identificador a enviar al handler :');
           registrar_entrada(_UrlBase,componentes[3]);            
        }
    },false);
}


function handler_document_keydown (event) {

                    let x = document.getElementById("scanner_barra");
                    var keyValue = event.key;
                    var codeValue = event.code;
                    console.log("key="+keyValue+ " Code="+codeValue); 

                    if (keyValue === 'Enter') {
//                           alert('Dato capturado ='+x.value);
                           var datos_pre_json = [{
                                                 'texto': x.value,
                                                 'tipo_documento': 'CI',
                                                 'modo_ingreso' :'escaner'
                                                }];  
                           console.log(datos_pre_json);
                           AjaxCall(_UrlBase+'/auth/getDestinos',JSON.stringify(datos_pre_json[0]), 'POST','JSON').done(function(response){
                                  console.log('llego respuesta');
                                  console.log(response);
                                  var json_obj = $.parseJSON(response);
                                  console.log(json_obj);
                                  procesarGetDestinos(json_obj);
                                  document.removeEventListener('keydown',handler_document_keydown,false);
                           });

                           x.value="";
                    }else if (!(keyValue === 'Shift') && !(keyValue === 'Tab') && !(keyValue === 'Control') && !(keyValue === 'Alt') && !(keyValue === 'Pause') && !(keyValue === 'CapsLock') && !(keyValue === 'Escape') && !(keyValue === 'Insert') && !(keyValue === 'Delete') && !(keyValue === 'Meta') && !(keyValue === 'ContextMenu')) {                                               
                       x.value = x.value + keyValue;                  
                    }    	
};


export {completarDatosPersona_init, destino_init, handler_document_keydown};


