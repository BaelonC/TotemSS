/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */
import {AjaxCall} from './LibCore.js';
import {completarDatosPersona_init, destino_init,handler_document_keydown} from './Generales.js';
import {programar_despedida} from './GraciasVisita_event_handler.js';
import {getRegistroManual} from './scanner_event_handler.js';
import {programar_eventos} from './NegarAcceso_event_handler.js';
import {obtenerVisitas} from './Tabla.js';

function registrar_entrada(urlBase,id_sala){
    console.log('destino_event_handler.js => registrar_entrada: '+ id_sala);
    
    var datos_pre_json = [{            
                          "nombre_visita": document.getElementById('destino_nombre_visita').innerHTML,
                          "apellido_p": document.getElementById('destino_apellido_p').innerHTML,
                          "apellido_m": document.getElementById('destino_apellido_m').innerHTML,
                          "tipo_documento": document.getElementById('destino_lbl_rut').innerHTML,
                          "rut_visita": document.getElementById('destino_rut_visita').innerHTML,
                          "establecimiento": document.getElementById('destino_establecimiento').innerHTML,
                          "id_sala": id_sala,
                          "codigo_pais": document.getElementById('destino_codigo_pais').innerHTML                          
                         }];    
    console.log(datos_pre_json);
    AjaxCall(urlBase+'/auth/safeVisita',JSON.stringify(datos_pre_json[0]), 'POST','JSON').done(function(response){
         console.log('llego respuest desde safeVisita');  
         var json_obj = $.parseJSON(response);
         console.log(json_obj);
         $('#inicio').html('');
         $('#inicio').append(json_obj['datos_html']);
         document.addEventListener('keydown',handler_document_keydown, false); 

         var obj = document.getElementById('scanner_OtroIdentificador');
         obj.addEventListener('click', (event ) => {
             getRegistroManual(_UrlBase);
         });    
         if(json_obj["tabla"] !== ""){           
            obtenerVisitas(_UrlBase, json_obj["tabla"]);
         }   
    });    
    
};


// Actualiza la GUI según respuesta del servicio getDestinos
function procesarGetDestinos(json_obj){
            console.log('destino_event_handler.js => procesarGetDestinos');
            if (json_obj['codigo'] === 0 ){
               $('#inicio').html('');
               $('#inicio').append(json_obj['datos_html']);                                           
               $( "#destino_tabs" ).tabs();
               if(json_obj["tabla"] !== ""){                  
                  obtenerVisitas(_UrlBase, json_obj["tabla"]);
               }
                destino_init();
               
            } else if (json_obj['codigo'] === 1){
               $('#otro_medio').html('');
               $('#otro_medio').append(json_obj['datos_html']);
               $('#otro_medio').removeClass('otro');
               $('#otro_medio').addClass('otro1');                                     
               completarDatosPersona_init();
            }  else if (json_obj['codigo'] === 2){
               $('#otro_medio').html('');
               $('#otro_medio').append(json_obj['datos_html']);               
               programar_despedida(json_obj);
            } else if (json_obj['codigo'] === 3){
               $('#otro_medio').html('');
               $('#otro_medio').append(json_obj['datos_html']); 
               programar_eventos();
            } else if (json_obj['codigo'] === -1 || json_obj['codigo'] === -2 ){                                      
               $('#inicio').html('');
               $('#inicio').append(json_obj['datos_html']);                                           
               $('#exampleModal').modal('show');
               var elementoModal = document.getElementById('exampleModal');
               elementoModal.addEventListener('hidden.bs.modal', (event) => {
                         window.location.href =json_obj['new_page'];
                },false);
            } else if( json_obj['codigo'] === -3){
                    console.log('agrega mensaje de rut invalido');
                    $('#mensajes-sistema').html('');
                    $('#mensajes-sistema').append(json_obj['datos_html']);                                           
                    console.log('Por prepara modal');
                    $('#exampleModal').modal('show');                    
                    console.log('modal instalado');
                    var elementoModal = document.getElementById('exampleModal');
           }      
};


export {registrar_entrada, procesarGetDestinos};
