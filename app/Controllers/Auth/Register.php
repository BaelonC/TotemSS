<?php 

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Libraries\TiposDoctoIdentificacion;
use App\Libraries\CamposQR;
use App\Libraries\Dto\EstablecimientoDto;
use App\Libraries\Dto\PersonaDto;
use App\Libraries\Dto\DestinoDto;
use App\Libraries\Establecimiento;
use App\Models\TotemModel;
use App\Libraries\Resultado;




class Register extends BaseController{    
    
    private $sesion;
    private TiposDoctoIdentificacion $oTiposDoctoIdentificacion;
    
    public function __construct() {
        $this->sesion = $session = \Config\Services::session();
        $this->oTiposDoctoIdentificacion = new TiposDoctoIdentificacion();
    }
    
    public function index($id){
        //carga la pagina inicial
        $datos= [           
                 'url_base' => base_url(),
                 'host' => ($id == 201) ? 'ancud' : (($id == 200) ? 'quellon' : (($id== 197) ? 'sschiloe' :'no conocido'))
                ];
        
        return $this->smartyView('Auth/inicio',$datos);      
    }
    
    public function inicio(){
      
        try{                        
          if ($this->request->isAjax()){                               
               $data_json = $this->request->getJSON(true);                                                            
               $hostname = $data_json["hostname"];
                 
               $oEstablecimientoDto = new EstablecimientoDto();
               $oEstablecimientoDto->setHost($hostname);
               
               //traer el nombre del establecimiento
               $oModelo = new TotemModel();
               $resultado = $oModelo->getEstablecimiento($oEstablecimientoDto);
               if ($resultado->getCodigoRetorno()<0){
                   throw new Exception('No se encuentra el establecimiento');
               }
               $this->sesion->set('oEstablecimientoDto',$oEstablecimientoDto);                              
               
               $data = [
                  'url_base' => base_url(),
                  'nombre_establecimiento'  => $oEstablecimientoDto->getNombre(),
                  'ayuda' => 'ayuda',
                  'rut_frente' => base_url().'/Imagenes/rut_frente_v2.png',
                  'rut_back' => base_url().'/Imagenes/rut_back_v2.png'
               ];
               $data_html=$this->smartyView("Auth/scaner", $data, true);
               $tabla = $this->smartyView("Auth/Tabla", $data, true);
               
               $datos= [                                   
                 'url_base' => base_url(),                 
                 'codigo' => $resultado->getCodigoRetorno(),  
                 'html' =>  $data_html,
                 'tabla' => ($oEstablecimientoDto->getId_establecimiento() == Establecimiento::$SSCHILOE) ? $tabla : ""
                ];    
                              
                return json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
           }
        } catch (Exception $ex) {
              switch ($ex->getMessage()) {
                  case 'No se encuentra el establecimiento':
                            $datos_error = [
                                'mensaje_titulo' => 'Totem',
                                'mensaje' => 'No es ṕosible reconocer este terminal en Totem, contacte a soporte (webmastersschiloe@saludchiloe.cl)'
                            ];
                            $data_html= $this->smartyView('Errores', $datos_error, true);
                            $datos= [                                   
                              'url_base' => base_url(),                 
                              'codigo' => -2,  
                              'html' =>  $data_html
                             ];    
                            break;
                  default:
                            $datos_error = [
                                'mensaje_titulo' => 'Totem',
                                'mensaje' => 'Estos es vergonzoso, reiniciaremos Totem'
                            ];
                            $data_html= $this->smartyView('Errores', $datos_error, true);
                            $datos= [                                   
                              'url_base' => base_url(),                 
                              'codigo' => -1,  
                              'new_page' => base_url().'/auth/home/'.$hostname,
                              'html' =>  $data_html
                             ];    
                            break;
              }
              return json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);                            
        }        
    }
    
    private function procesar_uri($dato){
        
        $oCampoQR = new CamposQR();
        
        $dato_fase1 = explode("=",$dato);
        $oCampoQR->setUrl(explode("?",$dato_fase1[0])[0]);        
        $dato_fase2 = explode("&", $dato_fase1[1]);
        $oCampoQR->setRutCompleto($dato_fase2[0]);
        $oCampoQR->setTipo(explode("&", $dato_fase1[2])[0]);
        $oCampoQR->setSerie(explode("&", $dato_fase1[3])[0]);
        $oCampoQR->setMrz(explode("&", $dato_fase1[4])[0]);
        return $oCampoQR;
    }
    
    private function validar_rut($dato):bool{
        $fase1 = explode("-",$dato);
        $largo = strlen($fase1[0])-1;
        $suma = 0;
        for($i=$largo; $i>=0; $i--){
           $factor=($largo-$i)%6+2;
           $suma = $suma + strval($fase1[0][$i])*$factor;   
        }
        $paso = 11 - $suma%11;
        if ($paso==11){
            $dv = "0";
        }elseif ($paso==10){
            $dv = "k";
        } else {
            $dv= strval($paso);
        }
        return ($fase1[1]==$dv ? true:false);
    }
    /***
     * Transforma $oCollectionDestinos en un arreglo de arreglo
     * donde $oCollectionDestinos es un arreglo de 2 campos 
     * ArrayDestinos y NumPisos. ArrayDestinos es a su vez un arreglo
     * de objetos DestinoDto y NumPisos un entero.
     * 
     * La función transforma esta estructura a una arreglo de pisos
     * que contiene un arreglo de salas (datos como string)
     */
    private function TransformarColeccion($oCollectionDestinos){
        
        $oTransformada [][]= [];
        for ($i= 0; $i<$oCollectionDestinos['NumPisos']; $i++){
                $oTransformada [$i]=[];
        }                
        foreach ($oCollectionDestinos['ArrayDestinos'] as $key => $value) {
            $oTransformada [$value->getPiso()-1][]= ["sala" => $value->getSala(),"id_sala"=> $value->getId()];
        }
        return $oTransformada;        
    }
    
    private function send_form_destinos(PersonaDto $oPersonaDto, EstablecimientoDto $oestablecimientoDto, TotemModel $omodelo ): array{

               // destinos 
               
               $oCollectionDestinos= $omodelo->getDatosdestinos($oestablecimientoDto);               
               $oTransformada = $this->TransformarColeccion($oCollectionDestinos->getData());
                           
               // traer html
               $datos= [                  
                 'url_base' => base_url(),
                 'NombrePersona' =>  $oPersonaDto->getNombre(),
                 'apellido_p'  => $oPersonaDto->getApaterno(),
                 'apellido_m' => $oPersonaDto->getAmaterno(),                   
                 'RutPersona' =>  ($oPersonaDto->getTipo_documento() == TiposDoctoIdentificacion::$CI ?  $oPersonaDto->getRut().'-'.$oPersonaDto->getDv(): $oPersonaDto->getPasaporte()),
                 'Establecimiento' => $oestablecimientoDto->getNombre(),                 
                 'TipoDocumento' =>  ($oPersonaDto->getTipo_documento() == TiposDoctoIdentificacion::$CI? 'RUT':TiposDoctoIdentificacion::$PASAPORTE),
                 'Destinos' => $oTransformada,
                 'nacionalidad' => $oPersonaDto->getPais(),
                 'codigo_pais' => $oPersonaDto->getCodigopais()
                ];    

               $datos_html=$this->smartyView('Auth/destino',$datos,true);    
               $tabla = $this->smartyView('Auth/Tabla',$datos,true);             
                //RESPONDER AL NAVEGADOR
                $respuesta_navegador = [                  
                 'url_base' => base_url(),
                 'datos_html' =>  $datos_html,
                 'codigo' => 0,
                 'tabla' => ($oestablecimientoDto->getId_establecimiento() == Establecimiento::$SSCHILOE) ? $tabla : ""
                ];
                
                return $respuesta_navegador;
    }
    
    private function send_form_completa_persona(PersonaDto $oPersonaDto, EstablecimientoDto $oestablecimientoDto, TotemModel $omodelo ): array{
        
               $datos= [                  
                 'url_base' => base_url(),                 
                 'RutPersona' => $oPersonaDto->getTipo_documento() == TiposDoctoIdentificacion::$CI? $oPersonaDto->getRut().'-'.$oPersonaDto->getDv(): $oPersonaDto->getPasaporte(),                 
                 'TipoDocumento'  => $oPersonaDto->getTipo_documento() == TiposDoctoIdentificacion::$CI? 'RUT': TiposDoctoIdentificacion::$PASAPORTE
                ];    
        
               $datos_html=$this->smartyView('Auth/completarDatosPersona',$datos,true);    

                //RESPONDER AL NAVEGADOR
                $respuesta_navegador = [                  
                 'url_base' => base_url(),
                 'datos_html' =>  $datos_html,
                 'codigo' => 1
                ];
                
                return $respuesta_navegador;               
    }
    
    private function send_form_acceso_denegado(PersonaDto $oPersonaDto, EstablecimientoDto $oestablecimientoDto, TotemModel $omodelo ): array{
        
               $datos= [                  
                 'url_base' => base_url(),                 
                 'RutPersona' => $oPersonaDto->getTipo_documento() == TiposDoctoIdentificacion::$CI? $oPersonaDto->getRut().'-'.$oPersonaDto->getDv(): $oPersonaDto->getPasaporte(),                 
                 'TipoDocumento'  => $oPersonaDto->getTipo_documento() == TiposDoctoIdentificacion::$CI? 'RUT': TiposDoctoIdentificacion::$PASAPORTE,
                 'nombre' => $oPersonaDto->getNombre(),
                 'apellido_p' => $oPersonaDto->getApaterno(),
                 'apellido_m' => $oPersonaDto->getAmaterno()  
                ];    
        
               $datos_html=$this->smartyView('Auth/NegarAcceso',$datos,true);    

                //RESPONDER AL NAVEGADOR
                $respuesta_navegador = [                  
                 'url_base' => base_url(),
                 'datos_html' =>  $datos_html,
                 'codigo' => 3
                ];
                
                return $respuesta_navegador;               
    }


    
    public function validarDatosPersona(){
       try{
          if ($this->request->isAjax()){                
               //recuperar parametros informados por el navegador
               // en este caso lo capturado por la pistola
               $data_json = $this->request->getJSON(true);                                             
               
               
               $tipo_documento = $data_json["tipo_documento"];
               
               
               $oPersonaDto = new PersonaDto();
              
               if($tipo_documento == TiposDoctoIdentificacion::$CI){               
                 $oQR= $this->procesar_uri($data_json["texto"]);
                 $oPersonaDto->setRut($oQR->getRut());
                 $oPersonaDto->setDv($oQR->getDv());
                 $oPersonaDto->setTipo_documento(TiposDoctoIdentificacion::$CI);
                 
               }elseif ($tipo_documento == TiposDoctoIdentificacion::$PASAPORTE) {
                 $oPersonaDto->setPasaporte($pasaporte);                 
                 $oPersonaDto->setTipo_documento(TiposDoctoIdentificacion::$PASAPORTE);
                    
                }
               //teaer establecimeinto
               
               $oestablecimientoDto = $this->sesion->get('oEstablecimientoDto');
               
//               $oestablecimientoDto= new EstablecimientoDto();
//               $oestablecimientoDto ->setHost('ancud');
//               $oestablecimientoDto ->setId_establecimiento('200');
//               $oestablecimientoDto ->setNombre('HANCUD');
               
               //necesito un señor totem model para resolver problemas
               $omodelo = new TotemModel();
               
               // datos persona               
               $resultado = $omodelo->getDatospersona($oPersonaDto);
               if ($resultado->getCodigoRetorno()< 0){
                   throw new Exception('No fue posible consultar datos de la persona');
               }
               if ($oPersonaDto->estaRegistrado()){
                 $respuesta_navegador =  $this->send_form_destinos($oPersonaDto, $oestablecimientoDto, $omodelo);
               }else{
                 $this->sesion->set('oPersonaDto',$oPersonaDto);
                 $respuesta_navegador =  $this->send_form_complete_person($oPersonaDto, $oestablecimientoDto, $omodelo);  
               }
               
          }
       } catch (Exception $ex) {
              null;
       }           
    }
    
    private function send_gracias_visita( PersonaDto $oPersonaDto,EstablecimientoDto $oestablecimientoDto){

               $datos= [                  
                 'url_base' => base_url(),
                 'NombrePersona' =>  $oPersonaDto->getNombre(),
                 'apellido_p'  => $oPersonaDto->getApaterno(),
                 'apellido_m' => $oPersonaDto->getAmaterno(),                   
                 'RutPersona' =>  ($oPersonaDto->getTipo_documento() == TiposDoctoIdentificacion::$CI ?  $oPersonaDto->getRut().'-'.$oPersonaDto->getDv(): $oPersonaDto->getPasaporte()),
                 'Establecimiento' => $oestablecimientoDto->getNombre(),                 
                 'host' => $oestablecimientoDto->getHost(),  
                 'TipoDocumento' =>  ($oPersonaDto->getTipo_documento() == TiposDoctoIdentificacion::$CI? 'RUT':TiposDoctoIdentificacion::$PASAPORTE),                
                 'nacionalidad' => $oPersonaDto->getPais(),
                 'codigo_pais' => $oPersonaDto->getCodigopais()
                ];    

               $datos_html=$this->smartyView('Auth/GraciasVisita',$datos,true);    
               $tabla = $this->smartyView('Auth/Tabla',$datos,true);               
                //RESPONDER AL NAVEGADOR
                $respuesta_navegador = [                  
                 'url_base' => base_url(),
                 'datos_html' =>  $datos_html,
                 'codigo' => 2,
                 'datos' => $datos
                ];
                
                return $respuesta_navegador;        
    }
    
    
    private function getDestinosConEscaner(array $data_json){
        
        $oestablecimientoDto = $this->sesion->get('oEstablecimientoDto');
        $oPersonaDto = new PersonaDto();
         
        try{
               $oQR= $this->procesar_uri($data_json["texto"]);
              
               $oPersonaDto->setRut($oQR->getRut());
               $oPersonaDto->setDv($oQR->getDv());
               $oPersonaDto->setTipo_documento($data_json["tipo_documento"]);
               $oPersonaDto->setCodigopais('CL');
               
               $oModelo = new TotemModel();
               $resultado1 = $oModelo->getNacionalidad($oPersonaDto);
               
               $oPersonaDto->setPais($resultado1->getData());
               
               $oPersonaDto2 = $oPersonaDto->clonar();
               $this->sesion->set('oPersonaDto',$oPersonaDto2);
               
               //teaer establecimeinto
               
              
               
//               $oestablecimientoDto= new EstablecimientoDto();
//               $oestablecimientoDto ->setHost('ancud');
//               $oestablecimientoDto ->setId_establecimiento('200');
//               $oestablecimientoDto ->setNombre('HANCUD');
               
               //necesito un señor totem model para resolver problemas
                              
               // datos persona               
               $resultado = $oModelo->getDatospersona($oPersonaDto);
               if ($resultado->getCodigoRetorno()< 0){
                   throw new Exception('No fue posible consultar datos de la persona');
               }
               //consultar si la persona tiene restricción de acceso si estamos en SSChiloe 
               $bool_acceso = True;
               if ($oestablecimientoDto->getId_establecimiento()== Establecimiento::$SSCHILOE) {
                    $resultado_restricciones = $oModelo->validarRestricciones($oPersonaDto);
                    if ($resultado_restricciones->getCodigoRetorno()<0) {
                        $bool_acceso = False;
                        throw new Exception('Restricciones no se pudieron verificar');                        
                    }else{
                        $bool_acceso = ($resultado_restricciones->getData()->getId()== -1) ? True: False;
                    }
               }

               
               if ($oPersonaDto->estaRegistrado() and $bool_acceso){
                  if(!$oPersonaDto->esVisitaActiva() ){
                    $respuesta_navegador =  $this->send_form_destinos($oPersonaDto, $oestablecimientoDto, $oModelo);
                  }else{                                   
                    $respuesta = $oModelo->marcarSalida($oPersonaDto);
                    $respuesta_navegador = $this->send_gracias_visita($oPersonaDto, $oestablecimientoDto);  
                  }
               }elseif ($oPersonaDto->estaRegistrado() and !$bool_acceso) {
                  $respuesta_navegador =  $this->send_form_acceso_denegado($oPersonaDto, $oestablecimientoDto, $oModelo);
               }else{
//                 $this->sesion->set('oPersonaDto',$oPersonaDto);
                 $respuesta_navegador =  $this->send_form_completa_persona($oPersonaDto, $oestablecimientoDto, $oModelo);  
               }               
               return json_encode($respuesta_navegador, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);;
        } catch (Exception $ex) {
            switch ($ex->getMessage()) {
                case 'No fue posible consultar datos de la persona':
                      $datos_error = [
                          'mensaje_titulo' => 'Totem',
                          'mensaje' => 'No fue posible recuperar los datos del RUT '.$oPersonaDto->getRut().'-'.$oPersonaDto->getDv()
                      ];
                      $data_html= $this->smartyView('Auth/Errores', $datos_error, true);
                      $datos= [                                   
                        'url_base' => base_url(),                 
                        'codigo' => -1,
                        'new_page' => base_url().'/auth/home/'.$oestablecimientoDto->getHost(),
                        'html' =>  $data_html
                       ];
                     break;
                default:
                      $datos_error = [
                          'mensaje_titulo' => 'Totem',
                          'mensaje' => 'Estos es vergonzoso, reiniciaremos Totem'
                      ];
                      $data_html= $this->smartyView('Auth/Errores', $datos_error, true);
                      $datos= [                                   
                        'url_base' => base_url(),                 
                        'codigo' => -2,  
                        'new_page' => base_url().'/auth/home/'.$oestablecimientoDto->getHost(), 
                        'html' =>  $data_html
                       ];
                     break;                    
            }
            return json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
    }
    
    private function rut_invalido(PersonaDto $oPersonaDto) : array{
                    
            $oEstablecimientoDto = $this->sesion->get('oEstablecimientoDto');
            $datos_error = [
                'mensaje_titulo' => 'Totem',
                'mensaje' => 'El RUT especificado no es válido ('.$oPersonaDto->getRut().'-'.$oPersonaDto->getDv().')'
            ];
            $data_html= $this->smartyView('Auth/Errores', $datos_error, true);
            $datos= [                                   
              'url_base' => base_url(),                 
              'codigo' => -3,
              'new_page' => base_url().'/auth/home/'.$oEstablecimientoDto->getHost(),
              'datos_html' =>  $data_html
             ];              
            return $datos;
    }
    
    /***
     * Servicio del Controller para responder request ajax con los destinos a 
     * los que puede dirigirse la visita según el establecimiento y lo capturado
     * por el escanner de código de barra.
     * 
     * La rutina asume que el documento escaneado es el código QR del rut del
     * visitante
     */
    
    private function getDestinosSinEscaner(array $datos_json){
        $oPersonaDto = new PersonaDto();

        $oPersonaDto->setCodigopais($datos_json['pais']);
        if($datos_json['tipo_documento'] == TiposDoctoIdentificacion::$CI){          
          $ci = explode("-",$datos_json['numero_identificacion']);
          $oPersonaDto->setRut($ci[0]);    
          $oPersonaDto->setDv($ci[1]);                    
          $oPersonaDto->setTipo_documento(TiposDoctoIdentificacion::$CI);
          if(!$this->validar_rut($datos_json['numero_identificacion'])){            
              /* agregar código para caso rut no válido*/                            
              $respuesta_navegador = $this->rut_invalido($oPersonaDto);
              return json_encode($respuesta_navegador, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
          }
        }elseif ($datos_json['tipo_documento'] == TiposDoctoIdentificacion::$PASAPORTE) {
            $oPersonaDto->setPasaporte($datos_json['numero_identificacion']);
            $oPersonaDto->setTipo_documento(TiposDoctoIdentificacion::$PASAPORTE);            
        }
        
        $oestablecimientoDto = $this->sesion->get('oEstablecimientoDto');

        $omodelo = new TotemModel();               
        
        $resultado = $omodelo->getNacionalidad($oPersonaDto);
        if ($resultado->getCodigoRetorno()>=0) {
            $oPersonaDto->setPais($resultado->getData());
        }else{
            $oPersonaDto->setPais('desconocido');
        }

        $oPersonaDto2 = $oPersonaDto->clonar();
        $this->sesion->set('oPersonaDto',$oPersonaDto2); 
      
        $resultado = $omodelo->getDatospersona($oPersonaDto);        
        
        if ($resultado->getCodigoRetorno()< 0){
           throw new Exception('No fue posible consultar datos de la persona');
        }

        
        //consultar si la persona tiene restricción de acceso si estamos en SSChiloe 
         $bool_acceso = True;
         if ($oestablecimientoDto->getId_establecimiento()== Establecimiento::$SSCHILOE) {
              $resultado_restricciones = $omodelo->validarRestricciones($oPersonaDto);
              if ($resultado_restricciones->getCodigoRetorno()<0) {
                  $bool_acceso = False;
                  throw new Exception('Restricciones no se pudieron verificar');                        
              }else{
                  $bool_acceso = ($resultado_restricciones->getData()->getId()== -1) ? True: False;
              }
         }
        
        if ($oPersonaDto->estaRegistrado() and $bool_acceso)  {                       
            if(!$oPersonaDto->esVisitaActiva() ){
              $respuesta_navegador =  $this->send_form_destinos($oPersonaDto, $oestablecimientoDto, $omodelo);
            }else{              
              $respuesta = $omodelo->marcarSalida($oPersonaDto);
              $respuesta_navegador = $this->send_gracias_visita($oPersonaDto, $oestablecimientoDto);  
            }
        }elseif($oPersonaDto->estaRegistrado() and !$bool_acceso) {
            $respuesta_navegador =  $this->send_form_acceso_denegado($oPersonaDto, $oestablecimientoDto, $omodelo);
        }else{
//              $this->sesion->set('oPersonaDto',$oPersonaDto);
//              $omodelo = new TotemModel();
//              $orespuesta = $omodelo->registrarPersona($oPersonaDto);
              
              $respuesta_navegador =  $this->send_form_completa_persona($oPersonaDto, $oestablecimientoDto, $omodelo);  
        }
                        
        return json_encode($respuesta_navegador, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);                
    }
    
    public function getDestinos(){
        
        try{                          
          if ($this->request->isAjax()){                
               //recuperar parametros informados por el navegador
               // en este caso lo capturado por la pistola
               $data_json = $this->request->getJSON(true);                                             
               
               
               if ($data_json['modo_ingreso']== 'escaner'){
                  return $this->getDestinosConEscaner($data_json);
               }elseif ($data_json['modo_ingreso']== 'manual') {
                  return $this->getDestinosSinEscaner($data_json);
                }
           }
        } catch (Exception $ex) {
            null;
        }       
        
    }
                
    /***
     * Servicio del controller que registra el destino de la visita
     * en establecimiento. Se asume que la petición es ajax y que se informan
     * los dartos de:
     * 
     * Nombre de la visita
     * Rut de la visita
     * identificador de la sala a la cual se dirige
     * Los datos del establecimiento son  posibles de obtener desde un variable
     * de session.
     *
     */
    public function safeVisita(){
          
        try{                             
                if ($this->request->isAjax()){                
                    //recuperar parametros informados por el navegador                               
                    $data_json = $this->request->getJSON(true);                    
                    $id_sala = $data_json["id_sala"];
                    
                    $oPersonaDto = new PersonaDto();                    
                    if ($data_json["tipo_documento"] === TiposDoctoIdentificacion::$PASAPORTE) {
                        $oPersonaDto->setPasaporte($data_json["rut_visita"]);
                        $oPersonaDto->setTipo_documento(TiposDoctoIdentificacion::$PASAPORTE);
                    }else{                        
                        $rut_aux = explode('-',$data_json["rut_visita"]);
                        $oPersonaDto->setRut($rut_aux['0']);
                        $oPersonaDto->setDv($rut_aux['1']);                                   
                        $oPersonaDto->setTipo_documento(TiposDoctoIdentificacion::$CI);
                    }
                    
                    $oPersonaDto->setNombre($data_json["nombre_visita"]);
                    $oPersonaDto->setApaterno($data_json["apellido_p"]);
                    $oPersonaDto->setAmaterno($data_json["apellido_m"]);
                    $oPersonaDto->setCodigopais($data_json['codigo_pais']);
                    
                    $oDestinoDto = new DestinoDto();
                    $oDestinoDto->setId($id_sala);
                 
                    $oModel = new TotemModel();
                    $oResultado = $oModel->safe_visita($oPersonaDto, $oDestinoDto);
                              
                    
                  if($oResultado->getCodigoRetorno()< 0){
                      throw new Exception("Visita no registrada");
                  }
                   
                  $oEstablecimientoDto =$this->sesion->get('oEstablecimientoDto');
                   
                  $data = [
                    'url_base' => base_url(),
                    'nombre_establecimiento'  => $oEstablecimientoDto->getNombre(),
                    'ayuda' => 'ayuda',
                    'rut_frente' => base_url().'/Imagenes/rut_frente_v2.png',
                    'rut_back' => base_url().'/Imagenes/rut_back_v2.png',
                    'host'=> $oEstablecimientoDto->getHost()
                  ];
                  $data_html=$this->smartyView("Auth/scaner", $data, true);                   
                  $tabla = $this->smartyView("Auth/Tabla", $data, true); 
                  //RESPODER AL NAVEGADOR
                  $respuesta_navegador = [                  
                    'url_base' => base_url(),
                    'datos_html' =>  $data_html,
                    'tabla' => ($oEstablecimientoDto->getId_establecimiento() == Establecimiento::$SSCHILOE) ? $tabla : ""
                   ];     
                  
                  return json_encode($respuesta_navegador, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);                     
                                          
                  }                        
        } catch (Exception $ex) {
                $oestablecimientoDto = $this->sesion->get('oEstablecimientoDto');                                   
                switch ($ex->getMessage()) {
                                  case "Visita no registrada":                                  
                      $datos_error = [
                          'mensaje_titulo' => 'Totem',
                          'mensaje' => 'Scanee su documento de identificación nuevamente '.$oPersonaDto->getRut().'-'.$oPersonaDto->getDv()
                      ];
                      $data_html= $this->smartyView('Errores', $datos_error, true);
                      $datos= [                                   
                        'url_base' => base_url(),                 
                        'codigo' => -1,
                        'new_page' => base_url().'/auth/home/'.$oestablecimientoDto->getHost(),
                        'html' =>  $data_html
                       ];
                     break;
                default:
                      $datos_error = [
                          'mensaje_titulo' => 'Totem',
                          'mensaje' => 'Estos es vergonzoso, reiniciaremos Totem'
                      ];
                      $data_html= $this->smartyView('Errores', $datos_error, true);
                      $datos= [                                   
                        'url_base' => base_url(),                 
                        'codigo' => -2,  
                        'new_page' => base_url().'/auth/home/'.$oestablecimientoDto->getHost(), 
                        'html' =>  $data_html
                       ];
                     break;                    
                }
        }
    }
    
    public function GetRegistroManual(){
        try{                             
                if ($this->request->isAjax()){                
                  //recuperar parametros informados por el navegador                               
                    
                  $oModel = new TotemModel();                                                  
                  $oResultado1 = $oModel->getPaises();  
                  
                  if($oResultado1->getCodigoRetorno()< 0){
                      throw new Exception("Paises no registrados");
                  }
                  $oResultado2 = $oModel->getTipDoctosIdentificacion();                   
                  if($oResultado2->getCodigoRetorno()< 0){
                      throw new Exception("Tipos de documentos de identificación no registrados");
                  }
                                    
                  $oEstablecimientoDto = $this->sesion->get('oEstablecimientoDto');
                   
                  $data = [
                    'url_base' => base_url(),
                    'nombre_establecimiento'  => $oEstablecimientoDto->getNombre(),
                    'paises' => $oResultado1->getData(),
                    'tipDctoIdentificacion' => $oResultado2->getData()  
                  ];
                  $data_html=$this->smartyView("Auth/sin_scaner", $data, true);                   

                  //RESPODER AL NAVEGADOR
                  $respuesta_navegador = [                  
                    'url_base' => base_url(),
                    'datos_html' =>  $data_html
                   ];     
                  
                  return json_encode($respuesta_navegador, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);                     
                                          
                  }                        
        } catch (Exception $ex) {
                $oestablecimientoDto = $this->sesion->get('oEstablecimientoDto');                                   
                switch ($ex->getMessage()) {
                                  case "Paises no registrados":
                                  case "Tipos de documentos de identificación no registrados":                                  
                      $datos_error = [
                          'mensaje_titulo' => 'Totem',
                          'mensaje' => 'Estos es vergonzoso, reiniciaremos Totem'
                      ];
                      $data_html= $this->smartyView('Errores', $datos_error, true);
                      $datos= [                                   
                        'url_base' => base_url(),                 
                        'codigo' => -1,
                        'new_page' => base_url().'/auth/home/'.$oestablecimientoDto->getHost(),
                        'html' =>  $data_html
                       ];
                     break;
                default:
                      $datos_error = [
                          'mensaje_titulo' => 'Totem',
                          'mensaje' => 'Estos es vergonzoso, reiniciaremos Totem'
                      ];
                      $data_html= $this->smartyView('Errores', $datos_error, true);
                      $datos= [                                   
                        'url_base' => base_url(),                 
                        'codigo' => -2,  
                        'new_page' => base_url().'/auth/home/'.$oestablecimientoDto->getHost(), 
                        'html' =>  $data_html
                       ];
                     break;                    
                }
        }        
    }
    
    public function safePersona(){

        try{                             
                if ($this->request->isAjax()){                
                    //recuperar parametros informados por el navegador                               
                    $data_json = $this->request->getJSON(true);                                        
                                                           
                    $oPersonaDto = $this->sesion->get('oPersonaDto');
                    $oPersonaDto->setNombre($data_json["nombre"]);
                    $oPersonaDto->setApaterno($data_json["apaterno"]);
                    $oPersonaDto->setAmaterno($data_json["amaterno"]);                
                                  
                    
                    $omodelo = new TotemModel();
                    $oResultado = $omodelo->registrarPersona($oPersonaDto);
                              
                    
                    if($oResultado->getCodigoRetorno()< 0){
                      throw new Exception("No se pudo actualizar los datos de la persona");
                    }
                   
                  $oestablecimientoDto = $this->sesion->get('oEstablecimientoDto');
                   
                  $respuesta_navegador = $this->send_form_destinos($oPersonaDto, $oestablecimientoDto, $omodelo);
                  
                  return json_encode($respuesta_navegador, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);                     
                                          
                  }                        
        } catch (Exception $ex) {
                $oestablecimientoDto = $this->sesion->get('oEstablecimientoDto');                                   
                switch ($ex->getMessage()) {
                                  case "Visita no registrada":                                  
                      $datos_error = [
                          'mensaje_titulo' => 'Totem',
                          'mensaje' => 'Scanee su documento de identificación nuevamente '.$oPersonaDto->getRut().'-'.$oPersonaDto->getDv()
                      ];
                      $data_html= $this->smartyView('Errores', $datos_error, true);
                      $datos= [                                   
                        'url_base' => base_url(),                 
                        'codigo' => -1,
                        'new_page' => base_url().'/auth/home/'.$oestablecimientoDto->getHost(),
                        'html' =>  $data_html
                       ];
                     break;
                default:
                      $datos_error = [
                          'mensaje_titulo' => 'Totem',
                          'mensaje' => 'Estos es vergonzoso, reiniciaremos Totem'
                      ];
                      $data_html= $this->smartyView('Errores', $datos_error, true);
                      $datos= [                                   
                        'url_base' => base_url(),                 
                        'codigo' => -2,  
                        'new_page' => base_url().'/auth/home/'.$oestablecimientoDto->getHost(), 
                        'html' =>  $data_html
                       ];
                     break;                    
                }
                
    }
}
    public function getVisitas(){

        try{                             
                if ($this->request->isAjax()){                
                                       
                    $omodelo = new TotemModel();
                    $oResultado = $omodelo->getVisitas();
                              
                    
                    if($oResultado->getCodigoRetorno()< 0){
                      throw new Exception("No se pudo obtener datos de visitas");
                    }                   
                  
                    $respuesta = ["codigo" => $oResultado->getCodigoRetorno()
                                ,"mensaje" => $oResultado->getMensaje()
                                ,"data" => $oResultado->getData()
                            ];
                    
                  return json_encode($respuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);                     
                                          
                  }                        
        } catch (Exception $ex) {
                                                  
                 $oestablecimientoDto = $this->sesion->get('oEstablecimientoDto');                                   
                switch ($ex->getMessage()) {
                                  case "No se pudo obtener datos de visitas":                                  
                      $datos_error = [
                          'mensaje_titulo' => 'Totem',
                          'mensaje' => 'Hubo un error obteniendo las visitas activas, favor intente nuevamente'
                      ];
                      $data_html= $this->smartyView('Errores', $datos_error, true);
                      $datos= [                                   
                        'url_base' => base_url(),                 
                        'codigo' => -1,
                        'new_page' => base_url().'/auth/home/'.$oestablecimientoDto->getHost(),
                        'html' =>  $data_html
                       ];
                     break;
                default:
                      $datos_error = [
                          'mensaje_titulo' => 'Totem',
                          'mensaje' => 'Estos es vergonzoso, reiniciaremos Totem'
                      ];
                      $data_html= $this->smartyView('Errores', $datos_error, true);
                      $datos= [                                   
                        'url_base' => base_url(),                 
                        'codigo' => -2,  
                        'new_page' => base_url().'/auth/home/'.$oestablecimientoDto->getHost(), 
                        'html' =>  $data_html
                       ];
                     break;                    
                }                     
              
        }
    }
    
    public function marcarSalida(){

        try{                             
            if ($this->request->isAjax()){                
                $data_json = $this->request->getJSON(true);

                $oPersonaDto = new PersonaDto();
                $oPersonaDto->setMarca_asociada($data_json["MARCA_ASOCIADA"]);
                
                $omodelo = new TotemModel();
                $respuesta = $omodelo->marcarSalida($oPersonaDto);           
                $oestablecimientoDto = $this->sesion->get('oEstablecimientoDto');
                $respuesta_navegador = $this->send_gracias_visita($oPersonaDto, $oestablecimientoDto);  
      

              return json_encode($respuesta_navegador, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);                     

              }                        
        } catch (Exception $ex) {
                                                  
               $oestablecimientoDto = $this->sesion->get('oEstablecimientoDto');                                   
                $datos_error = [
                              'mensaje_titulo' => 'Totem',
                              'mensaje' => 'Estos es vergonzoso, reiniciaremos Totem'
                              ];
                $data_html= $this->smartyView('Errores', $datos_error, true);
                $datos= [                                   
                  'url_base' => base_url(),                 
                  'codigo' => -2,  
                  'new_page' => base_url().'/auth/home/'.$oestablecimientoDto->getHost(), 
                  'html' =>  $data_html
                 ];                                     
              
        }
    }
}