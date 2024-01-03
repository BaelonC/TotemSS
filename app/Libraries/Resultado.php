<?php

namespace App\Libraries;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Resultado
 *
 * @author fgarcia
 */
class Resultado {
    //put your code here
    
    private $codigoRetorno;
    private $mensaje;
    private $data;
    private $backtrace;


    public function __construct($parametros){
        $this->codigoRetorno = $parametros['p_codigoRetorno'];
        $this->mensaje= $parametros['p_mensaje'];
        $this->data = $parametros['p_data'];
    }

    function getBacktrace() {
        return $this->backtrace;
    }

    function setBacktrace($backtrace) {
        $this->backtrace = $backtrace;
    }
        
    function getCodigoRetorno() {
        return $this->codigoRetorno;
    }

    function getMensaje() {
        return $this->mensaje;
    }

    function getData() {
        return $this->data;
    }

    function setCodigoRetorno($codigoRetorno) {
        $this->codigoRetorno = $codigoRetorno;
    }

    function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    function setData($data) {
        $this->data = $data;
    }

}