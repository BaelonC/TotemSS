/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

import {AjaxCall} from './LibCore.js';
import {completarDatosPersona_init, destino_init,handler_document_keydown} from './Generales.js';
import {programar_despedida} from './GraciasVisita_event_handler.js';

/**
 * Programar botón paera volver al inicio del sistema
 */
function programar_eventos() {
    var obj = document.getElementById('NegarAcceso_btn_volver');
         obj.addEventListener('click', (event ) => {
             
             location.replace( _UrlBase+'/auth/'+_host); 
         });                         
    /*programar_despedida("ahora");*/
}


export {programar_eventos};