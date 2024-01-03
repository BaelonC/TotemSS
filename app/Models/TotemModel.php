<?php

namespace App\Models;
use App\Libraries\Dto\EstablecimientoDto;
use App\Libraries\Dao\MarcaDao;
use App\Libraries\Dao\PaisesDao;
use App\Libraries\Dao\TipDoctoIdentificacionDAO;
use App\Libraries\BDOracle;
use App\Libraries\Dao\PersonaDao;
use App\Libraries\Dto\PersonaDto;
use App\Libraries\Dto\DestinoDto;
use App\Libraries\Dto\TipDoctoIdentificacion;
use App\Libraries\Dto\Pais;
use App\Libraries\Resultado;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of MarcasModel
 *
 * @author juan.urrutia
 */
class TotemModel {
   
  private BDOracle $oBDOracle;
    
  public function __construct() {              
       $this->oBDOracle = new BDOracle('chiloedata','totem','Sschiloe2022');    
  }
  
  public function __destruct() {
       $this->oBDOracle->close();
  }
  
  public function getEstablecimiento(EstablecimientoDto &$oEstablecimientoDto): Resultado {
      
      $oMarcaDao = new MarcaDao($this->oBDOracle);      
      return $oMarcaDao->getEstablecimiento($oEstablecimientoDto);
  }
    
  public function getDatospersona(PersonaDto &$oPersonaDto): Resultado {
      
      $oPersonaDao = new PersonaDao($this->oBDOracle);      
      return $oPersonaDao->getPersona($oPersonaDto);
  }
  
  public function getVisitas(): Resultado {
      
      $oMarcaDao = new MarcaDao($this->oBDOracle);      
      return $oMarcaDao->getVisitasActivas();
  }

  public function getDatosdestinos(EstablecimientoDto $oEstablecimientoDto):Resultado {
    
     $oMarcaDao = new MarcaDao($this->oBDOracle);      
     return $oMarcaDao->getDestinos($oEstablecimientoDto);   
  }
    
  public function safe_visita(PersonaDto $oPersonaDto, DestinoDto $oDestinoDto):Resultado{
      
      $oMarcaDao = new MarcaDao($this->oBDOracle);
      $resultado = $oMarcaDao->safe_visita($oPersonaDto, $oDestinoDto);
      if ($resultado->getCodigoRetorno() >= 0){
          $this->oBDOracle->commit();
      }else{
          $this->oBDOracle->rollback();
      }
      return $resultado;
  } 
  
  public function getPaises(): Resultado{
      $oPaisesDao = new PaisesDao($this->oBDOracle);
      $oPais = new Pais();   
      $resultado = $oPaisesDao->getPaises($oPais);   
   
      if ($resultado->getCodigoRetorno() >= 0){
          $this->oBDOracle->commit();
      }else{
          $this->oBDOracle->rollback();
      }
      return $resultado;
   
  }
  
  public function getTipDoctosIdentificacion(): Resultado{
      $oTipDctoIdentificacionDao = new TipDoctoIdentificacionDAO($this->oBDOracle);
      $oTipDctoIdentificacion = new TipDoctoIdentificacion();
      $resultado = $oTipDctoIdentificacionDao->getTipDoctosIdentificacion($oTipDctoIdentificacion);
         
      if ($resultado->getCodigoRetorno() >= 0){
          $this->oBDOracle->commit();
      }else{
          $this->oBDOracle->rollback();
      }
      return $resultado;
  }  
  
  public function registrarPersona(PersonaDto $oPersonaDto){
      $oPersonaDao = new PersonaDao($this->oBDOracle);
      $resultado = $oPersonaDao->safePersona($oPersonaDto);
      if ($resultado->getCodigoRetorno() >= 0){
          $this->oBDOracle->commit();
      }else{
          $this->oBDOracle->rollback();
      }
      return $resultado;      
  }
  
  public function getNacionalidad(PersonaDto $oPersonaDto):Resultado {
    
     $oPaisDao = new PaisesDao($this->oBDOracle);      
     return $oPaisDao->getNacionalidad($oPersonaDto);
  }
  
  public function marcarSalida(PersonaDto $oPersonaDto){
      
      $oMarca = new MarcaDao($this->oBDOracle);
      $resultado = $oMarca->marcarSalida($oPersonaDto);
      if ($resultado->getCodigoRetorno()>=0) {
          $this->oBDOracle->commit();
      }else{
          $this->oBDOracle->rollback();
      }
  }
  
  public function validarRestricciones(PersonaDto $oPersonaDto){
      
      $oPersonaDao = new PersonaDao($this->oBDOracle);
      $resultado = $oPersonaDao->validarRestricciones($oPersonaDto);

      return $resultado;      
      
  }
  
}