/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */
import {AjaxCall} from './LibCore.js';
import {destino_init} from './Generales.js';

    function updatePersona(urlBase){
    console.log('completarDatosPersona_event_handler.js => updatePersona');
    
    var datos_pre_json = [{                          
                          "nombre": document.getElementById('completarDatosPersona_nom_persona').value,
                          "apaterno": document.getElementById('completarDatosPersona_nom_apaterno').value,
                          "amaterno": document.getElementById('completarDatosPersona_nom_amaterno').value
                         }];    
    console.log(datos_pre_json);                     
    if ((datos_pre_json[0]["nombre"]==="" || datos_pre_json[0]["apaterno"]==="")) {
       alert('Los campos nombre y apellido paterno son obligatorio');
    }else{                     
            AjaxCall(urlBase+'/auth/safePersona',JSON.stringify(datos_pre_json[0]), 'POST','JSON').done(function(response){
                 console.log('llego respuest desde GetOtroTipoDocumento');  
                 var json_obj = $.parseJSON(response);
                 console.log(json_obj);         
                 $('#inicio').html('');
                 $('#inicio').append(json_obj['datos_html']);         
                 $('#destino_tabs'  ).tabs();
                 destino_init();
            });    
    }
}

export {updatePersona};