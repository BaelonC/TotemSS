<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Libraries\Dao;

use App\Libraries\Dto\Paises;
use App\Libraries\Dto\Pais;
use App\Libraries\Dto\PersonaDto;
use App\Libraries\BDOracle;
use App\Libraries\Resultado;

/**
 * Description of PaisDao
 *
 * @author juan.urrutia
 */
class PaisesDao {
    //put your code here
    private BDOracle $bd;
    public function __construct(BDOracle $oBDOracle) {
        $this->bd = $oBDOracle;
        
    }

    public function getPaises(Pais $oPais): Resultado{
        
        
        $resultado = new Resultado(array("p_codigoRetorno"=>0,"p_mensaje"=>"EXITO","p_data"=>"")); 
        try {
                    
            $sql = "select paises.id, paises.orden, paises.codigo, paises.descripcion from totem.grd_codigos paises where paises.nombre_grp = :grupo and paises.id_grp = :id_grupo and sysdate between paises.fec_inicio and nvl(paises.fec_fin,sysdate) order by paises.descripcion";
            
            $idp = oci_parse($this->bd->getConexion(), $sql);
            if (!$idp){
                throw new Exception("Error al pasear sql");
            }
            
            $id_grupo= $oPais->getID_GRP();
            oci_bind_by_name($idp,':id_grupo',$id_grupo ,10,SQLT_LNG);

            $grupo= $oPais->getNOMBRE_GRP();
            oci_bind_by_name($idp,':grupo',$grupo ,100,SQLT_CHR);

            
            $ide = oci_execute($idp);
            if (!$ide){
               throw new Exception("Error al ejecutar sql"); 
            } 
            $oPaises = [];
            
            $nfilas= oci_fetch_all($idp,$datos,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);                      
            foreach($datos as $data){
                $unPais = NEW Pais();
                $unPais->setID($data['ID']);
                $unPais->setORDEN($data['ORDEN']);
                $unPais->setCODIGO($data['CODIGO']);
                $unPais->setDESCRIPCION($data['DESCRIPCION']);
                $oPaises[]=$unPais;
            }
            $resultado->setData($oPaises);
            
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

    
    public function getNacionalidad(PersonaDto $oPersona): Resultado{
        
        
        $resultado = new Resultado(array("p_codigoRetorno"=>0,"p_mensaje"=>"EXITO","p_data"=>"")); 
        try {
                    
            $sql = "SELECT descripcion "
                    . "FROM grd_codigos "
                    . "WHERE codigo = UPPER(:codigo) "
                    . "AND SYSDATE BETWEEN fec_inicio AND NVL(fec_fin,SYSDATE) "
                    . "AND nombre_grp = 'PAIS DOCUMENTO' ";
            
            $idp = oci_parse($this->bd->getConexion(), $sql);
            if (!$idp){
                throw new Exception("Error al pasear sql");
            }
            
            $codigo= $oPersona->getCodigopais();
            oci_bind_by_name($idp,':codigo',$codigo ,20,SQLT_CHR);
            
            $ide = oci_execute($idp);
            if (!$ide){
               throw new Exception("Error al ejecutar sql"); 
            } 
            $oPaises = [];
            
            $row= oci_fetch_assoc($idp);                      
            $pais = $row['DESCRIPCION'];
            $resultado->setData($pais);
            
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
    
    
    
}
