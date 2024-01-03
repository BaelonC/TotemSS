<?php

namespace App\Libraries\Dao;
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of MarcaDao
 *
 * @author juan.urrutia
 */

use App\Libraries\TiposDoctoIdentificacion;
use App\Libraries\Dto\DestinoDto;
use App\Libraries\Dto\EstablecimientoDto;
use App\Libraries\Dto\PersonaDto;
use App\Libraries\Dto\MarcaDto;
use App\Libraries\BDOracle;
use App\Libraries\Resultado;


class MarcaDao {
    //put your code here
    private BDOracle $bd;
    public function __construct(BDOracle $oBDOracle) {
        $this->bd = $oBDOracle;  
    }
  
    public function getEstablecimiento(EstablecimientoDto &$oEstablecimiento): Resultado{
        
        $resultado = new Resultado(array("p_codigoRetorno"=>0,"p_mensaje"=>"EXITO","p_data"=>"")); 
        try {
                    
            $sql = "select est.id_establecimiento,est.nombre as nombre from establecimiento est where est.host = :host ";
            
            $idp = oci_parse($this->bd->getConexion(), $sql);
            if (!$idp){
                throw new Exception("Error al pasear sql");
            }
            
            $host=$oEstablecimiento->getHost();
            oci_bind_by_name($idp,':host',$host ,20,SQLT_CHR);
            
            $ide = oci_execute($idp,OCI_NO_AUTO_COMMIT);
            if (!$ide){
               throw new Exception("Error al ejecutar sql"); 
            }   
            $data = oci_fetch_array($idp, OCI_BOTH);
                        
            $oEstablecimiento->setNombre($data['NOMBRE']);
            $oEstablecimiento->setId_establecimiento($data['ID_ESTABLECIMIENTO']);
            
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
                                      break;
                }
                              return $resultado;
          }                    
    }
        
    public function getDestinos(EstablecimientoDto $oEstablecimiento): Resultado{
        
        $resultado = new Resultado(array("p_codigoRetorno"=>0,"p_mensaje"=>"EXITO","p_data"=>"")); 
        $Coleccion = ['ArrayDestinos'=>[],'NumPisos'=>1];
        try {
                    
            $sql = "select dest.sala, dest.piso, dest.id  from destino dest where dest.id_establecimiento = :id_establecimiento order by piso";
            
            $idp = oci_parse($this->bd->getConexion(), $sql);
            if (!$idp){
                throw new Exception("Error al pasear sql");
            }
            
            $id_dest=$oEstablecimiento->getId_establecimiento();
            oci_bind_by_name($idp,':id_establecimiento',$id_dest ,10,SQLT_LNG);
            
            $ide = oci_execute($idp);
            if (!$ide){
               throw new Exception("Error al ejecutar sql"); 
            }   
            $nfilas= oci_fetch_all($idp,$data,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            $max_pisos = 1;
            foreach($data as $arrayinterno){                
                    $oDestinoDto = new DestinoDto();                        
                    $oDestinoDto->setSala($arrayinterno['SALA']);
                    $oDestinoDto->setPiso($arrayinterno['PISO']);
                    $oDestinoDto->setId($arrayinterno['ID']);
                    if ($arrayinterno['PISO']>$max_pisos){
                        $max_pisos = $arrayinterno['PISO'];
                    }
                    $Coleccion['ArrayDestinos'][] = $oDestinoDto;
            }
            
            $Coleccion['NumPisos']=$max_pisos;
                        
            $resultado->setData($Coleccion);
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
                                      break;
                }
                              return $resultado;
          } 
    }   
    
public function safe_visita(PersonaDto $oPersonaDto, DestinoDto $oDestinoDto): Resultado{
        $resultado = new Resultado(array("p_codigoRetorno"=>0,"p_mensaje"=>"EXITO","p_data"=>"")); 
        
        try {
            $sql = "insert into marcas (id, rut, dv, nombre,  apellido_p, apellido_m, f_acceso, activo ,id_destino, pasaporte, codigo_pais ) values ( sq_marca.nextval, :rut, :dv, :nombre,  :apellido_p, :apellido_m, SYSDATE, 'S' ,:id_destino, :pasaporte, :codigo_pais )";
            
            $idp = oci_parse($this->bd->getConexion(), $sql);
            if (!$idp){
                throw new Exception("Error al pasear insert");
            }
            if ($oPersonaDto->getTipo_documento()== TiposDoctoIdentificacion::$CI){
               $tmp1 = $oPersonaDto->getRut();          
               oci_bind_by_name($idp,':rut', $tmp1,10,SQLT_LNG);
               $tmp2 = $oPersonaDto->getDv();
               oci_bind_by_name($idp,':dv',$tmp2 ,1,SQLT_CHR);
               $tmp3 = null;
               oci_bind_by_name($idp,':pasaporte',$tmp3 ,100,SQLT_CHR);
               
            }elseif ($oPersonaDto->getTipo_documento()== TiposDoctoIdentificacion::$PASAPORTE) {
               $tmp1 = null;          
               oci_bind_by_name($idp,':rut', $tmp1,10,SQLT_LNG);
               $tmp2 = null;
               oci_bind_by_name($idp,':dv',$tmp2 ,1,SQLT_CHR);
               $tmp3 = $oPersonaDto->getPasaporte();
               oci_bind_by_name($idp,':pasaporte',$tmp3 ,100,SQLT_CHR);
            }   
            
            $tmp4 = $oPersonaDto->getNombre();
            oci_bind_by_name($idp,':nombre', $tmp4,100,SQLT_CHR);
            $tmp5 = $oPersonaDto->getApaterno();            
            oci_bind_by_name($idp,':apellido_p',$tmp5 ,100,SQLT_CHR);
            $tmp6 = $oPersonaDto->getAmaterno();
            oci_bind_by_name($idp,':apellido_m',$tmp6 ,100,SQLT_CHR);
            $tmp7 =$oDestinoDto->getId();
            oci_bind_by_name($idp,':id_destino',$tmp7 ,10,SQLT_LNG);
            $tmp8 = $oPersonaDto->getCodigopais();
            oci_bind_by_name($idp,':codigo_pais',$tmp8 ,2,SQLT_CHR);                            
               
            $ide = oci_execute($idp);
            if (!$ide){
               throw new Exception("Error al ejecutar insert"); 
            }               
            
            return $resultado;
        } catch (Exception $ex) {
                switch ($ex->getMessage()) {
                                  case 'No conecta BD':
                                      $e = oci_error();
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-1);                               
                                      break;
                                  case 'Error al pasear insert':
                                      $resultado->setMensaje($ex->getMessage());
                                      $resultado->setCodigoRetorno(-2);
                                      break;                       
                                  case 'Error al ejecutar insert':
                                      $e = oci_error($this->db->getConexion());
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-3);                        
                                      break;       
                                  default:
                                      break;
                }
                              return $resultado;

        }
}
  
public function marcarSalida(PersonaDto $oPersonaDto): Resultado{
        $resultado = new Resultado(array("p_codigoRetorno"=>0,"p_mensaje"=>"EXITO","p_data"=>"")); 
        
        try {
            $sql = "UPDATE marcas "
                    . "SET activo = 'N' "
                    . "WHERE "
                    . " id = :id ";
            
            $idp = oci_parse($this->bd->getConexion(), $sql);
            if (!$idp){
                throw new Exception("Error al pasear update");
            }
            
            $tmp1 = $oPersonaDto->getMarca_asociada();
            oci_bind_by_name($idp,':id', $tmp1,10,SQLT_LNG);
                           
            $ide = oci_execute($idp);
            if (!$ide){
               throw new Exception("Error al ejecutar update"); 
            }               
            
            return $resultado;
        } catch (Exception $ex) {
                switch ($ex->getMessage()) {
                                  case 'No conecta BD':
                                      $e = oci_error();
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-1);                               
                                      break;
                                  case 'Error al pasear update':
                                      $resultado->setMensaje($ex->getMessage());
                                      $resultado->setCodigoRetorno(-2);
                                      break;                       
                                  case 'Error al ejecutar update':
                                      $e = oci_error($this->db->getConexion());
                                      $resultado->setMensaje($e['message'].$e['sqltext']);
                                      $resultado->setCodigoRetorno(-3);                        
                                      break;       
                                  default:
                                      break;
                }
                              return $resultado;
        }
}

    public function getVisitasActivas(): Resultado{
        
        $resultado = new Resultado(array("p_codigoRetorno"=>0,"p_mensaje"=>"EXITO","p_data"=>"")); 
        try {
            
            $establecimiento = ESTABLECIMIENTO["SSCHILOE"];
            
            $sql = "SELECT 
                        mc.id as MARCA_ASOCIADA,
                        to_char(mc.f_acceso, 'dd-mm-yyyy hh24:mi') as FECHA,
                        mc.nombre,
                        mc.apellido_p,
                        mc.apellido_m,
                        mc.rut || '-' || mc.dv as RUT,
                        mc.codigo_pais,
                        dt.piso,
                        dt.sala
                    FROM 
                        totem.marcas mc,
                        totem.destino dt
                    WHERE
                           dt.id = mc.id_destino
                      AND  dt.id_establecimiento = :id_establecimiento
                      AND  mc.activo = 'S'";
            
            $idp = oci_parse($this->bd->getConexion(), $sql);
            if (!$idp){
                throw new Exception("Error al pasear sql");
            }
            
            oci_bind_by_name($idp,':id_establecimiento', $establecimiento,10,SQLT_LNG);
            
            $ide = oci_execute($idp,OCI_NO_AUTO_COMMIT);
            if (!$ide){
               throw new Exception("Error al ejecutar sql"); 
            }   
            
            $respuesta = oci_fetch_all($idp, $data, 0, -1, OCI_FETCHSTATEMENT_BY_ROW);
             
//            $data = oci_fetch_array($idp, OCI_BOTH);
            
            $resultado->setData($data);
            
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
                                      break;
                }
                              return $resultado;
          }                    
    }

}
