<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Libraries;

/**
 * Description of CamposQR
 *
 * @author juan.urrutia
 */
class CamposQR {
    //put your code here
    private $url;
    private $rutCompleto;
    private $rut;
    private $dv;
    private $tipo;
    private $serie;
    private $mrz;
    
    public function getUrl() {
        return $this->url;
    }

    public function getRut() {
        return $this->rut;
    }

    public function getDv() {
        return $this->dv;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getSerie() {
        return $this->serie;
    }

    public function getMrz() {
        return $this->mrz;
    }

    public function getRutCompleto() {
        return $this->rutCompleto;
    }
   
    public function setUrl($url): void {
        $this->url = $url;
    }

    public function setRutCompleto($rut): void {
        $this->rutCompleto = $rut;
        $tmp = explode("-",$rut);        
        if ( count($tmp) == 2){
            $this->rut = $tmp[0];
            $this->dv = $tmp[1];
        }
    }
    
    public function setRut($rut): void {
        $this->rut = $rut;
    }    
    
    public function setDv($dv): void {
        $this->dv = $dv;
    }

    public function setTipo($tipo): void {
        $this->tipo = $tipo;
    }

    public function setSerie($serie): void {
        $this->serie = $serie;
    }

    public function setMrz($mrz): void {
        $this->mrz = $mrz;
    }

    
}
