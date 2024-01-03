/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

import {handler_document_keydown} from './Generales.js';

var temporizador;
var host;
function programar_despedida(json_obj){
         console.log('GraciasVisita_event_handler.js ==> programar_despedidda');         
         
//         var obj = document.getElementById('gracias_visita_inicio');
//         obj.addEventListener('keypress', ()=>{                             
//                location.replace( _UrlBase+'/auth/'+_host);    
//         },false);
                  
         document.addEventListener('keydown',handler_document_keydown, false); 
         temporizador = setTimeout(home,5000);
}

/**
 * Manejador del evento click para el botón INICIO
 */
function home() {
    console.log('GraciasVisita_event_handler.js => home');    
    console.log('valor host  = ' + _host);
    clearTimeout(temporizador);
    location.replace( _UrlBase+'/auth/'+_host);    
}

export {programar_despedida};