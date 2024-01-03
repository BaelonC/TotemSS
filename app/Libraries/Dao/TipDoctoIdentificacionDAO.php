<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Libraries\Dao;


use App\Libraries\Dto\TipDoctoIdentificacion;
use App\Libraries\BDOracle;
use App\Libraries\Resultado;


/**
 * Description of TipDoctoIdentificacionDAO
 *
 * @author juan.urrutia
 */
class TipDoctoIdentificacionDAO {
    //put your code here
    private BDOracle $bd;
    public function __construct(BDOracle $oBDOracle) {
        $this->bd = $oBDOracle;
        
    }

    public function getTipDoctosIdentificacion(TipDoctoIdentificacion $oTipDoctoIdentificacion): Resultado{
        
        
        $resultado = new Resultado(array("p_codigoRetorno"=>0,"p_mensaje"=>"EXITO","p_data"=>"")); 
        try {
                    
            $sql = "select tipdoc.id, tipdoc.orden, tipdoc.codigo, tipdoc.descripcion from totem.grd_codigos tipdoc where tipdoc.nombre_grp = :grupo and tipdoc.id_grp = :id_grupo and sysdate between tipdoc.fec_inicio and nvl(tipdoc.fec_fin,sysdate) order by tipdoc.descripcion";
            
            $idp = oci_parse($this->bd->getConexion(), $sql);
            if (!$idp){
                throw new Exception("Error al pasear sql");
            }
            
            $id_grupo= $oTipDoctoIdentificacion->getID_GRP();
            oci_bind_by_name($idp,':id_grupo',$id_grupo ,10,SQLT_LNG);

            $grupo= $oTipDoctoIdentificacion->getNOMBRE_GRP();
            oci_bind_by_name($idp,':grupo',$grupo ,100,SQLT_CHR);

            
            $ide = oci_execute($idp);
            if (!$ide){
               throw new Exception("Error al ejecutar sql"); 
            } 
            $oTipDoctoIdentificaciones = [];
            
            $nfilas= oci_fetch_all($idp,$datos,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);                      
            foreach($datos as $data){
                $unTipDctoIdentificacion = NEW TipDoctoIdentificacion();
                $unTipDctoIdentificacion->setID($data['ID']);
                $unTipDctoIdentificacion->setORDEN($data['ORDEN']);
                $unTipDctoIdentificacion->setCODIGO($data['CODIGO']);
                $unTipDctoIdentificacion->setDESCRIPCION($data['DESCRIPCION']);
                $oTipDoctoIdentificaciones[]= $unTipDctoIdentificacion;
            }
            $resultado->setData($oTipDoctoIdentificaciones);
            
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
