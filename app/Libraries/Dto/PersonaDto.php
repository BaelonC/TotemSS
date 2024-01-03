<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Libraries\Dto;

/**
 * Description of PersonaDto
 *
 * @author juan.urrutia
 */
class PersonaDto {
    //put your code here
    private $rut;
    private $dv;
    private $pasaporte;
    private $nombre;   
    private $apaterno;
    private $amaterno;
    private $tipo_documento;
    private $codigopais;
    private $pais;
    private $estado;
    private $ultimo_acceso;
    private $marca_asociada;
    private $id;
    
    
    public function getMarca_asociada() {
        return $this->marca_asociada;
    }

    public function setMarca_asociada($marca_asociada): void {
        $this->marca_asociada = $marca_asociada;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id): void {
        $this->id = $id;
    }

        
    public function getEstado() {
        return $this->estado;
    }

    public function getUltimo_acceso() {
        return $this->ultimo_acceso;
    }

    public function setEstado($estado): void {
        $this->estado = $estado;
    }

    public function setUltimo_acceso($ultimo_acceso): void {
        $this->ultimo_acceso = $ultimo_acceso;
    } 
    
    public function getPais() {
        return $this->pais;
    }

    public function setPais($pais): void {
        $this->pais = $pais;
    }        
    
    public function getRut() {
        return $this->rut;
    }

    public function getDv() {
        return $this->dv;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApaterno() {
        return $this->apaterno;
    }

    public function getAmaterno() {
        return $this->amaterno;
    }

    public function setRut($rut): void {
        $this->rut = $rut;
    }

    public function setDv($dv): void {
        $this->dv = $dv;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setApaterno($apaterno): void {
        $this->apaterno = $apaterno;
    }

    public function setAmaterno($amaterno): void {
        $this->amaterno = $amaterno;
    }
 
    public function getTipo_documento() {
        return $this->tipo_documento;
    }

    public function setTipo_documento($tipo_documento): void {
        $this->tipo_documento = $tipo_documento;
    }

    public function getPasaporte() {
        return $this->pasaporte;
    }

    public function setPasaporte($pasaporte): void {
        $this->pasaporte = $pasaporte;
    }

    public function getCodigopais() {
        return $this->codigopais;
    }

    public function setCodigopais($codigopais): void {
        $this->codigopais = $codigopais;
    }

    
    public function estaRegistrado(): bool {
        if ($this->nombre == '' or $this->apaterno == '' ){
            return false;
        }else{
            return true;
        }
    }
    
    public function esVisitaActiva(): bool{
        if ($this->estado == 'S') {
            $fecha_actual = date('d-m-Y');
            $hora_actual =  date('H:i:s');
            $tmp = explode(':',$hora_actual);
            $segundos_actuales=intval($tmp[0])*60*60+intval($tmp[1])*60+intval($tmp[2]);
            
            $tmp = explode(' ',$this->ultimo_acceso);
            $fecha_registrada = $tmp[0];        
            $hora_registrada = $tmp[1];
            
            $tmp = explode(':',$hora_registrada);
            $segundos_registrados = intval($tmp[0])*60*60+intval($tmp[1])*60+intval($tmp[2]);
            
            $dias_fecha_actual = date('z');
            $dt_fecha_registrada = new \DateTime($fecha_registrada);
            $num_dias_registrado = $dt_fecha_registrada->format('z');
                        
            $segundos_totales_actuales = $dias_fecha_actual*24*60*60+$segundos_actuales;
            $segundos_totales_registrado = $num_dias_registrado*24*60*60+$segundos_registrados;
            
            if (abs($segundos_totales_actuales-$segundos_totales_registrado) >= MAX_SEGUNDOS_VISITA) {
               return false;                      
            }else {
               return true;                                
            }
        }else{
            return false;
        }
    }    
    
    public function clonar() : PersonaDto{
        
        $oPersona2 = new PersonaDto();        
        
        $oPersona2->setPais($this->pais);
        $oPersona2->setCodigopais($this->codigopais);
        $oPersona2->setTipo_documento($this->tipo_documento);
        $oPersona2->setPasaporte($this->pasaporte);
        $oPersona2->setRut($this->rut);
        $oPersona2->setDv($this->dv);
        
        $oPersona2->setNombre($this->nombre);
        $oPersona2->setAmaterno($this->amaterno);
        $oPersona2->setApaterno($this->apaterno);
        
        return $oPersona2;
    }
}
