//Función javascript que captura la información de una pistola desde
//un evento del DOM. 
//El objeto del DOM es pasado por parametro mediante su id
import {AjaxCall} from './modulos/LibCore.js';
import {getRegistroManual} from './modulos/scanner_event_handler.js';
import {addchar, delchar, ChangeTeclado, registroManual } from './modulos/sin_escaner_event_handler.js';
import {registrar_entrada} from './modulos/destino_event_handler.js';
import {updatePersona} from './modulos/completarDatosPersona_event_handler.js';
import {completarDatosPersona_init, destino_init, handler_document_keydown} from './modulos/Generales.js';
import {obtenerVisitas} from './modulos/Tabla.js';


window.onload=function(){
    console.log('pistolas.js => windows.onload=function');
    console.log("window.onload");
    var datos_pre_json = [{"hostname": _host}];
    console.log(datos_pre_json);
    AjaxCall(_UrlBase+'/auth/home',JSON.stringify(datos_pre_json[0]), 'POST','JSON').done(function(response){
           console.log('llego respuesta');
           var json_obj = $.parseJSON(response);      
           console.log(json_obj);
           if (json_obj['codigo'] >= 0){
              $('#inicio').html('');
              $('#inicio').append(json_obj['html']);  
              escaner_init(json_obj['url_base'],'barra');
              
              if(json_obj["tabla"] !== ""){                   
                  obtenerVisitas(_UrlBase, json_obj["tabla"]);
              }
              
          }else if (json_obj['codigo'] === -1 || json_obj['codigo'] === -2) {
              $('#inicio').html('');
              $('#inicio').append(json_obj['html']);  
              $('#exampleModal').modal('show');
              elementoModal = document.getElementById('exampleModal');
              elementoModal.addEventListener('hidden.bs.modal', event => {
                  window.location.href =json_obj['new_page'];
              });
          }
    });   
};


//function handler_document_keydown (event) {
//
//                    let x = document.getElementById("barra");
//                    var keyValue = event.key;
//                    var codeValue = event.code;
//                    console.log("key="+keyValue+ " Code="+codeValue); 
//
//                    if (keyValue === 'Enter') {
//                           alert('Dato capturado ='+x.value);
//                           var datos_pre_json = [{
//                                                 'texto': x.value,
//                                                 'tipo_documento': 'CI',
//                                                 'modo_ingreso' :'escaner'
//                                                }];  
//                           console.log(datos_pre_json);
//                           AjaxCall(urlBase+'/auth/getDestinos',JSON.stringify(datos_pre_json[0]), 'POST','JSON').done(function(response){
//                                  console.log('llego respuesta');
//                                  console.log(response);
//                                  var json_obj = $.parseJSON(response);
//                                  console.log(json_obj);
//                                  procesarGetDestinos(json_obj);
//                                  document.removeEventListener('keydown',handler_document_keydown,false);
//                           });
//
//                           x.value="";
//                    }else if (!(keyValue === 'Shift') && !(keyValue === 'Tab') && !(keyValue === 'Control') && !(keyValue === 'Alt') && !(keyValue === 'Pause') && !(keyValue === 'CapsLock') && !(keyValue === 'Escape') && !(keyValue === 'Insert') && !(keyValue === 'Delete') && !(keyValue === 'Meta') && !(keyValue === 'ContextMenu')) {                                               
//                       x.value = x.value + keyValue;                  
//                    }    	
//};

function escaner_init (urlBase,id) {
        console.log('pistolas.js => escaner_init'); 
        document.addEventListener('keydown',handler_document_keydown, false);    
        
        var obj = document.getElementById('scanner_OtroIdentificador');
        obj.addEventListener('click', (event ) => {
            getRegistroManual(_UrlBase);
        });                
};

//function destino_init(){
//
//    var obj = document.getElementById("destino_destinos");
//    obj.addEventListener('click', (event) => {
//        var id = event.target.attributes[0].value;
//        var componentes = id.split('_');
//        registrar_entrada(_UrlBase,componentes[2]);
//    },false);
//}
