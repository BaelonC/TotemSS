/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

import {AjaxCall} from './LibCore.js';
import {addchar, delchar, ChangeTeclado, registroManual, configurar_cedula_chilena, filtrar_pais_tipo_documento} from './sin_escaner_event_handler.js';
import {handler_document_keydown} from './Generales.js';

function getRegistroManual(urlBase){
    console.log('escaner_event_handler.js => getRegistroManual');
    
    document.removeEventListener('keydown',handler_document_keydown, false);
    
    var datos_pre_json = [{                          
                          "establecimiento": document.getElementById('scanner_establecimiento').innerHTML                          
                         }];    
    console.log(datos_pre_json);
    AjaxCall(urlBase+'/auth/GetRegistroManual',JSON.stringify(datos_pre_json[0]), 'POST','JSON').done(function(response){
         console.log('llego respuest desde GetOtroTipoDocumento');  
         var json_obj = $.parseJSON(response);
         console.log(json_obj);         
         $('#otro_medio').html('');
         $('#otro_medio').append(json_obj['datos_html']);         
         $('#otro_medio').removeClass('otro');
         $('#otro_medio').addClass('otro1');         
              
         sin_escaner_init();
    });    
};

/**
 * Configura todos los manejadores @description eventos que requiere el fragmento de vista 
 */
function sin_escaner_init () {
    console.log('escaner_event_handler.js => sin_escaner_init');
    var obj = null;
    var i = 0;
    for (i = 0; i< 10; i++){
        var obj = document.getElementById('sin_escaner_tecla'+String(i));
        obj.addEventListener('click', (event )=>{       
           addchar(event.target.innerText);     
        });                
    }
    
//    var obj = document.getElementById('sin_escaner_tecla1');
//    obj.addEventListener('click', (event )=>{       
//       addchar(event.target.innerText);     
//    });
//    
//    obj = document.getElementById('sin_escaner_tecla2');
//    obj.addEventListener('click', (event )=>{
//       addchar(event.target.innerText);     
//    });
//    
//    obj = document.getElementById('sin_escaner_tecla3');
//    obj.addEventListener('click', (event )=>{
//       addchar(event.target.innerText);     
//    });
//    
//    obj = document.getElementById('sin_escaner_tecla4');
//    obj.addEventListener('click', (event )=>{
//       addchar(event.target.innerText);     
//    });
//    
//    obj = document.getElementById('sin_escaner_tecla5');
//    obj.addEventListener('click', (event )=>{
//       addchar(event.target.innerText);     
//    });
//    
//    obj = document.getElementById('sin_escaner_tecla6');
//    obj.addEventListener('click', (event )=>{
//       addchar(event.target.innerText);     
//    });
//    
//    obj = document.getElementById('sin_escaner_tecla7');
//    obj.addEventListener('click', (event )=>{
//       addchar(event.target.innerText);     
//    });
//    
//    obj = document.getElementById('sin_escaner_tecla8');
//    obj.addEventListener('click', (event )=>{
//       addchar(event.target.innerText);     
//    });
//    
//    obj = document.getElementById('sin_escaner_tecla9');
//    obj.addEventListener('click', (event )=>{
//       addchar(event.target.innerText);     
//    });
//    
//    obj = document.getElementById('sin_escaner_tecla0');
//    obj.addEventListener('click', (event )=>{
//       addchar(event.target.innerText);     
//    });
    
    obj = document.getElementById('sin_escaner_tipteclado');
    obj.addEventListener('click', (event )=>{
       ChangeTeclado();     
    });

    obj = document.getElementById('sin_escaner_teclaDEL');
    obj.addEventListener('click', (event )=>{
       delchar();     
    });

    obj = document.getElementById('sin_escanear_btn_registrar');
    obj.addEventListener('click', (event )=>{
       registroManual(_UrlBase,);     
    });
    
    var oPaises = document.getElementById('sin_escaner_lstpaises');            
    console.log('valor = ' + oPaises.value);
    oPaises.addEventListener('change', (event ) => {
        configurar_cedula_chilena();
    });    
    
    var oTipoDocumento = document.getElementById('sin_escaner_TipDocto');
    oTipoDocumento.addEventListener('change', (event) => {
        filtrar_pais_tipo_documento();
    })
    
    
};

export{getRegistroManual};