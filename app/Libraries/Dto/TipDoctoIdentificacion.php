<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Libraries\Dto;

/**
 * Description of TipDoctoIdentificacion
 *
 * @author juan.urrutia
 */
class TipDoctoIdentificacion {
    //put your code here
    protected $ID;
    protected $ID_GRP = 1;
    protected $NOMBRE_GRP='TIPOS DE DOCUMENTOS';
    protected $CODIGO;
    protected $DESCRIPCION;
    protected $ORDEN;
    protected $FEC_INICIO;
    protected $FEC_FIN;    
    
    public function getID() {
        return $this->ID;
    }

    public function getCODIGO() {
        return $this->CODIGO;
    }

    public function getDESCRIPCION() {
        return $this->DESCRIPCION;
    }

    public function getORDEN() {
        return $this->ORDEN;
    }

    public function getFEC_INICIO() {
        return $this->FEC_INICIO;
    }

    public function getFEC_FIN() {
        return $this->FEC_FIN;
    }

    public function setID($ID): void {
        $this->ID = $ID;
    }

    public function setCODIGO($CODIGO): void {
        $this->CODIGO = $CODIGO;
    }

    public function setDESCRIPCION($DESCRIPCION): void {
        $this->DESCRIPCION = $DESCRIPCION;
    }

    public function setORDEN($ORDEN): void {
        $this->ORDEN = $ORDEN;
    }

    public function setFEC_INICIO($FEC_INICIO): void {
        $this->FEC_INICIO = $FEC_INICIO;
    }

    public function setFEC_FIN($FEC_FIN): void {
        $this->FEC_FIN = $FEC_FIN;
    }

    public function getID_GRP() {
        return $this->ID_GRP;
    }

    public function getNOMBRE_GRP() {
        return $this->NOMBRE_GRP;
    }

    
}
