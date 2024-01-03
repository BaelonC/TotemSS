<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */
namespace App\Libraries\Dao;

/**
 * Description of PersonaDao
 *
 * @author juan.urrutia
 */

use App\Libraries\Dto\PersonaDto;
use App\Libraries\BDOracle;
use App\Libraries\Resultado;
use App\Libraries\TiposDoctoIdentificacion;

class PersonaDao {
      //put your code here
    private BDOracle $bd;
    public function __construct(BDOracle $oBDOracle) {
        $this->bd = $oBDOracle;
        
    }

    private function getPersonaRut(PersonaDto &$oPersona): Resultado{
        
        $resultado = new Resultado(array("p_codigoRetorno"=>0,"p_mensaje"=>"EXITO","p_data"=>"")); 
        try {
                    
            
             $sql = " SELECT "
                    ."  vi.nombre "
                    ." ,vi.apellido_p "
                    ." ,vi.apellido_m "
                    ." ,vi.codigo_pais "
                    ." ,vi.estado "
                    ." ,vi.fec_acceso "
                    ." ,NVL(TO_CHAR(ma2.id),'SIN DATOS') AS MARCA_ASOCIADA "
                    ."FROM "      
                    ."    (SELECT "
                    ."         pe.nombre "
                    ."        ,pe.apellido_p "
                    ."        ,pe.apellido_m "
                    ."        ,pe.codigo_pais "
                    ."        ,pe.rut "
                    ."        ,nvl(ma.activo, 'SIN DATO')                                          AS estado "
                    ."        ,nvl(to_char(MAX(ma.f_acceso),'dd-mm-yyyy HH24:MI:SS'), 'SIN FECHA') AS fec_acceso "                         
                    ."     FROM "
                    ."          personas pe "
                    ."          LEFT JOIN marcas   ma ON pe.rut = ma.rut "
                    ."                               AND ma.activo = 'S' "
                    ."     WHERE "
                    ."        pe.rut = :rut "
                    ."     GROUP BY "
                    ."         pe.nombre "
                    ."        ,pe.apellido_p "
                    ."        ,pe.apellido_m "
                    ."        ,pe.codigo_pais "
                    ."        ,pe.rut "
                    ."        ,ma.activo "
                    ."    ) vi left join marcas ma2 ON "
                    ."                                 ma2.rut = vi.rut "
                    ."                             AND vi.fec_acceso = TO_CHAR(ma2.f_acceso,'dd-mm-yyyy HH24:MI:SS') ";
            
            $idp = oci_parse($this->bd->getConexion(), $sql);
            if (!$idp){
                throw new Exception("Error al pasear sql");
            }
            
            $rut=$oPersona->getRut();
            oci_bind_by_name($idp,':rut',$rut ,10,SQLT_LNG);
            
            $ide = oci_execute($idp);
            if (!$ide){
               throw new Exception("Error al ejecutar sql"); 
            } 

            $data = oci_fetch_array($idp, OCI_ASSOC);
                                  
            if (is_bool($data)){
               $oPersona->setNombre('');
               $oPersona->setAmaterno('');
               $oPersona->setApaterno('');
               $oPersona->setCodigopais('');
               $oPersona->setEstado('SIN DATO');
               $oPersona->setUltimo_acceso('SIN FECHA');               
               $oPersona->setMarca_asociada('SIN DATO');
            }else{
                $oPersona->setNombre($data['NOMBRE']);
                $oPersona->setAmaterno($data['APELLIDO_M']);
                $oPersona->setApaterno($data['APELLIDO_P']);
                $oPersona->setCodigopais($data['CODIGO_PAIS']);
                $oPersona->setEstado($data['ESTADO']);
                $oPersona->setUltimo_acceso($data['FEC_ACCESO']);
                $oPersona->setMarca_asociada($data['MARCA_ASOCIADA']);
            }
            oci_free_statement($idp);
            return $resultado;
        } catch (Exception $ex) {
                switch ($ex->getMessage()) {
                                  case 'No conecta BD':
                                      $e = oci_error();
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-1);                               
                                      break;
                                  case 'Error al pasear sql':
                                      $resultado->setMensaje($ex->getMessage());
                                      $resultado->setCodigoRetorno(-2);
                                      break;                       
                                  case 'Error al ejecutar sql':
                                      $e = oci_error($this->db->getConexion());
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-3);                        
                                      break;       
                                  default:
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-4);                                                              
                                      break;
                }
                              return $resultado;
          }                    
        
    }
    
    private function getPersonaPasaporte(PersonaDto &$oPersona): Resultado{
        
        $resultado = new Resultado(array("p_codigoRetorno"=>0,"p_mensaje"=>"EXITO","p_data"=>"")); 
        try {
                    
//            $sql = "select nombre, apellido_p, apellido_m, codigo_pais from personas  where pasaporte= :pasaporte";

            $sql = "SELECT "
                  ."  vi.nombre "
                  ." ,vi.apellido_p "
                  ." ,vi.apellido_m "
                  ." ,vi.codigo_pais "
                  ." ,vi.estado "
                  ." ,vi.fec_acceso "
                  ." ,NVL(TO_CHAR(ma2.id),'SIN DATOS') AS MARCA_ASOCIADA "
                  ."FROM "
                  ."    (SELECT "
                  ."         pe.nombre "
                  ."        ,pe.apellido_p "
                  ."        ,pe.apellido_m "
                  ."        ,pe.codigo_pais "
                  ."        ,pe.pasaporte "
                  ."        ,nvl(ma.activo, 'SIN DATO')                                          AS estado "
                  ."        ,nvl(to_char(MAX(ma.f_acceso),'dd-mm-yyyy HH24:MI:SS'), 'SIN FECHA') AS fec_acceso "
                  ."     FROM "
                  ."          personas pe "
                  ."          LEFT JOIN marcas   ma ON pe.pasaporte = ma.pasaporte "
                  ."                               AND ma.activo = 'S' "
                  ."     WHERE "
                  ."        pe.pasaporte= :pasaporte "
                  ."     GROUP BY "
                  ."         pe.nombre "
                  ."        ,pe.apellido_p "
                  ."        ,pe.apellido_m "
                  ."        ,pe.codigo_pais "
                  ."        ,pe.pasaporte "
                  ."        ,ma.activo "
                  ."    ) vi left join marcas ma2 ON "
                  ."                                 ma2.pasaporte = vi.pasaporte "
                  ."                             AND vi.fec_acceso = TO_CHAR(ma2.f_acceso,'dd-mm-yyyy HH24:MI:SS') ";
            
            $idp = oci_parse($this->bd->getConexion(), $sql);
            if (!$idp){
                throw new Exception("Error al pasear sql");
            }
            
            $pasaporte=$oPersona->getPasaporte();
            oci_bind_by_name($idp,':pasaporte',$pasaporte ,10,SQLT_LNG);
            
            $ide = oci_execute($idp);
            if (!$ide){
               throw new Exception("Error al ejecutar sql"); 
            } 

            $data = oci_fetch_array($idp, OCI_ASSOC);
                                  
            if (is_bool($data)){
               $oPersona->setNombre('');
               $oPersona->setAmaterno('');
               $oPersona->setApaterno('');
               $oPersona->setCodigopais('');
               $oPersona->setEstado('SIN DATO');
               $oPersona->setUltimo_acceso('SIN FECHA');               
               $oPersona->setMarca_asociada('SIN DATO');
            }else{
                $oPersona->setNombre($data['NOMBRE']);
                $oPersona->setAmaterno($data['APELLIDO_M']);
                $oPersona->setApaterno($data['APELLIDO_P']);
                $oPersona->setCodigopais($data['CODIGO_PAIS']);
                $oPersona->setEstado($data['ESTADO']);
                $oPersona->setUltimo_acceso($data['FEC_ACCESO']);
                $oPersona->setMarca_asociada($data['MARCA_ASOCIADA']);
            }
            oci_free_statement($idp);
            return $resultado;
        } catch (Exception $ex) {
                switch ($ex->getMessage()) {
                                  case 'No conecta BD':
                                      $e = oci_error();
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-1);                               
                                      break;
                                  case 'Error al pasear sql':
                                      $resultado->setMensaje($ex->getMessage());
                                      $resultado->setCodigoRetorno(-2);
                                      break;                       
                                  case 'Error al ejecutar sql':
                                      $e = oci_error($this->db->getConexion());
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-3);                        
                                      break;       
                                  default:
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-4);                                                              
                                      break;
                }
                              return $resultado;
          }                    
        
    }


    
    public function getPersona(PersonaDto &$oPersona): Resultado{
        
        $resultado = new Resultado(array("p_codigoRetorno"=>0,"p_mensaje"=>"EXITO","p_data"=>"")); 
        try {
            if ($oPersona->getTipo_documento() == TiposDoctoIdentificacion::$CI){
                return ($this->getPersonaRut($oPersona));                   
            }elseif ($oPersona->getTipo_documento() == TiposDoctoIdentificacion::$PASAPORTE) {
                return ($this->getPersonaPasaporte($oPersona));                   
            }else{
                throw new Exception("Persona sin tipo de documento de identificación"); 
            }
            
        } catch (Exception $ex) {
                switch ($ex->getMessage()) {
                                  case 'No conecta BD':
                                      $e = oci_error();
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-1);                               
                                      break;
                                  case 'Error al pasear sql':
                                      $resultado->setMensaje($ex->getMessage());
                                      $resultado->setCodigoRetorno(-2);
                                      break;                       
                                  case 'Error al ejecutar sql':
                                      $e = oci_error($this->db->getConexion());
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-3);                        
                                      break;       
                                  case 'Persona sin tipo de documento de identificación':                                      
                                      $resultado->setMensaje($e['message']);
                                      $resultado->setCodigoRetorno(-4);                        
                                      break;                                             
                                  default:
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-5);                                                              
                                      break;
                }
                              return $resultado;
          }                    
    }
        

    private function safePersonaRUT(PersonaDto $oPersonaDto): Resultado {
        $resultado = new Resultado(array("p_codigoRetorno"=>0,"p_mensaje"=>"EXITO","p_data"=>"")); 
        try {
            $sql = "insert into personas (rut,dv,nombre, apellido_p, apellido_m, tipo_documento, codigo_pais, id) values "
                    . "(:rut,:dv,:nombre,:apellido_p,:apellido_m, :tipo_documento, :codigo_pais, sq_persona.nextval)";
            $idp = oci_parse($this->bd->getConexion(), $sql);
            if (!$idp){
                throw new Exception("Error al pasear sql");
            }
            $rut=$oPersonaDto->getRut();
            oci_bind_by_name($idp,':rut',$rut ,10,SQLT_LNG);            
            
            $dv=$oPersonaDto->getDv();
            oci_bind_by_name($idp,':dv',$dv ,1,SQLT_CHR);            
            
            $nombre=$oPersonaDto->getNombre();
            oci_bind_by_name($idp,':nombre',$nombre ,100,SQLT_CHR);            

            $apaterno=$oPersonaDto->getApaterno();
            oci_bind_by_name($idp,':apellido_p',$apaterno ,30,SQLT_CHR);            
            
            $tipo_documento = $oPersonaDto->getTipo_documento();
            oci_bind_by_name($idp,':tipo_documento',$tipo_documento ,20,SQLT_CHR);            
            
            $amaterno=$oPersonaDto->getAmaterno();
            oci_bind_by_name($idp,':apellido_m',$amaterno ,30,SQLT_CHR);            

            $codigo_pais=$oPersonaDto->getCodigopais();
            oci_bind_by_name($idp,':codigo_pais',$codigo_pais ,2,SQLT_CHR);            
            
            $ide = oci_execute($idp);
            if (!$ide){
               throw new Exception("Error al ejecutar sql"); 
            }             
            
            oci_free_statement($idp);
            
            return $resultado;
            
        } catch (Exception $ex) {
                switch ($ex->getMessage()) {
                                  case 'Error al pasear sql':
                                      $resultado->setMensaje($ex->getMessage());
                                      $resultado->setCodigoRetorno(-2);
                                      break;                       
                                  case 'Error al ejecutar sql':
                                      $e = oci_error($this->db->getConexion());
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-3);                        
                                      break;       
                                  default:
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-4);                        
                                      break;
                }
                              return $resultado;
            
        }        
    }

    private function safePersonaPASAPORTE(PersonaDto $oPersonaDto): Resultado {
        $resultado = new Resultado(array("p_codigoRetorno"=>0,"p_mensaje"=>"EXITO","p_data"=>"")); 
        try {
            $sql = "insert into personas (pasaporte, nombre, apellido_p, apellido_m, tipo_documento, codigo_pais, id) values "
                    . "(:pasaporte,:nombre,:apellido_p,:apellido_m, :tipo_documento, :codigo_pais, sq_persona.nextval)";
            $idp = oci_parse($this->bd->getConexion(), $sql);
            if (!$idp){
                throw new Exception("Error al pasear sql");
            }
            $pasaporte=$oPersonaDto->getPasaporte();
            oci_bind_by_name($idp,':pasaporte',$pasaporte ,100,SQLT_LNG);            
                        
            $nombre=$oPersonaDto->getNombre();
            oci_bind_by_name($idp,':nombre',$nombre ,100,SQLT_CHR);            

            $apaterno=$oPersonaDto->getApaterno();
            oci_bind_by_name($idp,':apellido_p',$apaterno ,30,SQLT_CHR);            
            
            $amaterno=$oPersonaDto->getAmaterno();
            oci_bind_by_name($idp,':apellido_m',$amaterno ,30,SQLT_CHR);            

            $tipo_documento=$oPersonaDto->getTipo_documento();
            oci_bind_by_name($idp,':tipo_documento',$tipo_documento ,20,SQLT_CHR);            
                        
            $codigo_pais=$oPersonaDto->getCodigopais();
            oci_bind_by_name($idp,':codigo_pais',$codigo_pais ,2,SQLT_CHR);            
            
            $ide = oci_execute($idp);
            if (!$ide){
               throw new Exception("Error al ejecutar sql"); 
            }             
            
            oci_free_statement($idp);
            
            return $resultado;
            
        } catch (Exception $ex) {
                switch ($ex->getMessage()) {
                                  case 'Error al pasear sql':
                                      $resultado->setMensaje($ex->getMessage());
                                      $resultado->setCodigoRetorno(-2);
                                      break;                       
                                  case 'Error al ejecutar sql':
                                      $e = oci_error($this->db->getConexion());
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-3);                        
                                      break;       
                                  default:
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-4);                        
                                      break;
                }
                              return $resultado;
            
        }        
    }

    /***
     * safePersona registra en la BD los datos de una nueva persona por rut o pasaporte
     * Se puede darb el caso que una persona este dos veces una por rut y otra por pasaporte
     * esta condición no se valida
     */
    public function safePersona(PersonaDto $oPersonaDto): Resultado {
        
        $resultado = new Resultado(array("p_codigoRetorno"=>0,"p_mensaje"=>"EXITO","p_data"=>"")); 
        if ($oPersonaDto->getTipo_documento()== TiposDoctoIdentificacion::$CI){
            return $this->safePersonaRUT($oPersonaDto);
        }elseif ($oPersonaDto->getTipo_documento()== TiposDoctoIdentificacion::$PASAPORTE){
            return $this->safePersonaPASAPORTE($oPersonaDto);
        }        
    }

    
    private function validarRestriccionesRut(PersonaDto $oPersona): Resultado{
        try {

            $resultado = new Resultado(array("p_codigoRetorno"=>0,"p_mensaje"=>"EXITO","p_data"=>"")); 
            $oPersona2 = new PersonaDto();
            
             $sql =  "SELECT pe.rut
                            ,pe.dv
                            ,pe.nombre
                            ,pe.apellido_p
                            ,pe.apellido_m
                            ,pe.id
                     FROM   restricciones re
                            RIGHT JOIN personas pe ON re.clave = pe.rut
                     WHERE  re.valor = :rut
                     AND re.familia_clave = 'RUT'
                     AND NVL(re.fec_hasta,TRUNC(SYSDATE)) >= TRUNC(SYSDATE)";
                                 
            $idp = oci_parse($this->bd->getConexion(), $sql);
            if (!$idp){
                throw new Exception("Error al pasear sql");
            }
            
            $rut=$oPersona->getRut();
            oci_bind_by_name($idp,':rut',$rut ,10,SQLT_LNG);
            
            $ide = oci_execute($idp);
            if (!$ide){
               throw new Exception("Error al ejecutar sql"); 
            } 
            
            $num_row = oci_fetch_all($idp,$data,null,null, OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
                                  
            if ($num_row == 0){
               $oPersona2->setNombre('');
               $oPersona2->setAmaterno('');
               $oPersona2->setApaterno('');
               $oPersona2->setCodigopais('');
               $oPersona2->setEstado('SIN DATO');
               $oPersona2->setUltimo_acceso('SIN FECHA');               
               $oPersona2->setMarca_asociada('SIN DATO');
               $oPersona2->setId(-1);
            }else{
               $oPersona2->setRut($data[0]['RUT']);                
               $oPersona2->setDv($data[0]['DV']);
               $oPersona2->setNombre($data[0]['NOMBRE']);
               $oPersona2->setApaterno($data[0]['APELLIDO_P']);
               $oPersona2->setAmaterno($data[0]['APELLIDO_M']);
               $oPersona2->setId($data[0]['ID']);
            }
            $resultado->setData($oPersona2);
            
            oci_free_statement($idp);
            return $resultado;
        } catch (Exception $ex) {
                switch ($ex->getMessage()) {
                                  case 'No conecta BD':
                                      $e = oci_error();
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-1);                               
                                      break;
                                  case 'Error al pasear sql':
                                      $resultado->setMensaje($ex->getMessage());
                                      $resultado->setCodigoRetorno(-2);
                                      break;                       
                                  case 'Error al ejecutar sql':
                                      $e = oci_error($this->db->getConexion());
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-3);                        
                                      break;       
                                  default:
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-4);                                                              
                                      break;
                }
                              return $resultado;
          }                    
        
    }

    /***
     * Esta función debe ser mejorada si bien considera que la persona que genera la restricción posee un pasaporte como 
     * documento de identificación se ha de considerar que las restricciones pueden ser de tipo rut o pasaporte y de momento
     * solo son de tipo rut
     * Se asume que enum el instante de ser creado este código no se contempla esta funcionalidad  para este tipo de documentos
    case CaseName;
}
     */    
    private function validarRestriccionesPasaporte(PersonaDto $oPersona): Resultado{
        try {

            $resultado = new Resultado(array("p_codigoRetorno"=>0,"p_mensaje"=>"EXITO","p_data"=>"")); 
            $oPersona2 = new PersonaDto();
            
             $sql =  "SELECT pe.rut
                            ,pe.dv
                            ,pe.nombre
                            ,pe.apellido_p
                            ,pe.apellido_m
                            ,pe.id
                     FROM   restricciones re
                            RIGHT JOIN personas pe ON re.clave = pe.rut
                     WHERE  re.valor = :rut
                     AND re.familia_clave = 'PASAPORTE'
                     AND SYSDATE BETWEEN re.fec_desde AND NVL(re.fec_hasta,SYSDATE)";
                                 
            $idp = oci_parse($this->bd->getConexion(), $sql);
            if (!$idp){
                throw new Exception("Error al pasear sql");
            }
            
            $rut=$oPersona->getRut();
            oci_bind_by_name($idp,':rut',$rut ,10,SQLT_LNG);
            
            $ide = oci_execute($idp);
            if (!$ide){
               throw new Exception("Error al ejecutar sql"); 
            } 
            
            $num_row = oci_fetch_all($idp,$data,null,null, OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
                                  
            if ($num_row == 0){
               $oPersona2->setNombre('');
               $oPersona2->setAmaterno('');
               $oPersona2->setApaterno('');
               $oPersona2->setCodigopais('');
               $oPersona2->setEstado('SIN DATO');
               $oPersona2->setUltimo_acceso('SIN FECHA');               
               $oPersona2->setMarca_asociada('SIN DATO');
               $oPersona2->setId(-1);
            }else{
               $oPersona2->setRut($data['RUT']);                
               $oPersona2->setDv($data['DV']);
               $oPersona2->setNombre($data['NOMBRE']);
               $oPersona2->setApaterno($data['APELLIDO_P']);
               $oPersona2->setAmaterno($data['APELLIDO_M']);
               $oPersona2->setId($data['ID']);
            }
            $resultado->setData($oPersona2);
            
            oci_free_statement($idp);
            return $resultado;
        } catch (Exception $ex) {
                switch ($ex->getMessage()) {
                                  case 'No conecta BD':
                                      $e = oci_error();
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-1);                               
                                      break;
                                  case 'Error al pasear sql':
                                      $resultado->setMensaje($ex->getMessage());
                                      $resultado->setCodigoRetorno(-2);
                                      break;                       
                                  case 'Error al ejecutar sql':
                                      $e = oci_error($this->db->getConexion());
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-3);                        
                                      break;       
                                  default:
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-4);                                                              
                                      break;
                }
                              return $resultado;
          }                    
        
    }
    
    public function validarRestricciones(PersonaDto $oPersona): Resultado{
        
        $resultado = new Resultado(array("p_codigoRetorno"=>0,"p_mensaje"=>"EXITO","p_data"=>"")); 
        try {
            if ($oPersona->getTipo_documento() == TiposDoctoIdentificacion::$CI){
                return ($this->validarRestriccionesRut($oPersona));                   
            }elseif ($oPersona->getTipo_documento() == TiposDoctoIdentificacion::$PASAPORTE) {
                return ($this->validarRestriccionesPasaporte($oPersona));                   
            }else{
                throw new Exception("Persona sin tipo de documento de identificación"); 
            }
            
        } catch (Exception $ex) {
                switch ($ex->getMessage()) {
                                  case 'No conecta BD':
                                      $e = oci_error();
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-1);                               
                                      break;
                                  case 'Error al pasear sql':
                                      $resultado->setMensaje($ex->getMessage());
                                      $resultado->setCodigoRetorno(-2);
                                      break;                       
                                  case 'Error al ejecutar sql':
                                      $e = oci_error($this->db->getConexion());
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-3);                        
                                      break;       
                                  case 'Persona sin tipo de documento de identificación':                                      
                                      $resultado->setMensaje($e['message']);
                                      $resultado->setCodigoRetorno(-4);                        
                                      break;                                             
                                  default:
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-5);                                                              
                                      break;
                }
                              return $resultado;
          }                    
    }
    
}
