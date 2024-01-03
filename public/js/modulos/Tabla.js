/* global urlBase */

import {AjaxCall} from './LibCore.js';
import {procesarGetDestinos} from './destino_event_handler.js';

function obtenerVisitas(urlBase, tabla_html) {
    console.log('Tabla.js => obtenerVisitas');
        
    var datos_pre_json = [{}];                    
                     
    AjaxCall(urlBase+'/auth/getVisitas',JSON.stringify(datos_pre_json[0]), 'POST','JSON').done(function(response){
        
         var json_obj = $.parseJSON(response);
         console.log(json_obj["data"]);
         
         if((json_obj["data"]).length > 0){
            $('#divTabla').remove();
            $('#scanner_recepcion').append(tabla_html);
            configurar_tabla(json_obj["data"], urlBase);            
         }else{
            $('#divTabla').remove();
         }    
    });  
}

function configurar_tabla(datos, urlBase){
        console.log('Tabla.js.configurar_tabla');
        destruirTabla();        
 	let tabla = $('#idTabla').DataTable({  
        searching: false,    
        pageLength: 5,
        lengthMenu: [[5,10],[5,10]],      
        data: datos,
        columns:[
                    {"data":"FECHA","title":"Fecha","width":"5%"},
                    {"data":"NOMBRE",
                     "title":"Nombre",
                     "width":"15%",
                     render: function(data, type, row, meta){                           
                                                        
                            return row.NOMBRE+" "+row.APELLIDO_P+" "+row.APELLIDO_M;
                        }
                    },                    
                    {"data":"RUT","title":"Rut", "width":"3%"},
                    {"data":"PISO","title":"Piso", "width":"1%"},
                    {"data":"SALA","title":"Sala", "width":"10%"},
                    {"data":null
                    ,"title":"Marcar Salida"
                    ,"width":"5%"
                    ,render: function(data, type, row, meta){                           
                                                        
                            return "<div class='d-flex justify-content-center'><button class='btn btn-primary btn-sm' id='btn-salir'><i class='bi bi-box-arrow-right'></i></button></div>";
                        }                                        
                    }
                ],
         language:{                
                processing: "Procesando",
                emptyTable: "No hay datos",
                zeroRecords: "No hay coincidencias en su busqueda",
                search: "Buscar: ",
                info: "Mostrando _END_ registros de _TOTAL_ ",
                lengthMenu: "Mostrar _MENU_ registros por página",
                select: {
                    rows: {
                        0: "Ninguna fila seleccionada",
                        1: "1 fila seleccionada"
                    }
                },
                paginate:{
                    first: "Primera",
                    previous: "Anterior",
                    next: "Siguiente",
                    last: "Última"
                }
         }      
	});        
        tabla.on("click", '#btn-salir', function(){           
           console.log("click en boton Salir");
           let dato = tabla.row($(this).parents('tr')).data();
           console.log(dato);
           
           datos = [{
                   "numero_identificacion": dato.RUT
                  ,"tipo_documento": "CI"
                  ,"pais": dato.CODIGO_PAIS
           }];
//           console.log(datos);
           marcarSalida(dato.MARCA_ASOCIADA, urlBase);
           
        });       
        tabla.off('select').on('select', function(e, dt, type, indexes){

        });
    
};


function destruirTabla() {
    if($.fn.DataTable.isDataTable('#idTabla')){
            $('#idTabla').DataTable().clear().destroy();
    }
    $('#idTabla').empty();   
}


function marcarSalida(MARCA_ASOCIADA, urlBase) {
    var datos_pre_json = [{             
                            'MARCA_ASOCIADA': MARCA_ASOCIADA
                         }]; 
                         
    console.log(datos_pre_json);
        AjaxCall(urlBase+'/auth/marcarSalida',JSON.stringify(datos_pre_json[0]), 'POST','JSON').done(function(response){
             console.log('llego respuesta desde GetDestinos');  
             var json_obj = $.parseJSON(response);
             console.log(json_obj);                  
     

             procesarGetDestinos(json_obj);
        });
}


export { obtenerVisitas };