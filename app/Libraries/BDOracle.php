<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Libraries;
use PDO;


/**
 * Description of BDOracle
 *
 * @author juan.urrutia
 */
class BDOracle {
    //put your code here
    private  $conexion;
    private $estado;
    
    public function __construct(string $servicio,string $usuario,string $clave) {
        $this->conexion = oci_connect($usuario,$clave,$servicio );
              
    }
       
    public function getConexion() {
        return $this->conexion;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado): void {
        $this->estado = $estado;
    }

    public function commit() {
        oci_commit($this->conexion);
    }
    
    public function rollback(){
        oci_rollback($this->conexion);
    }
    
    public function close(){
        oci_close($this->conexion);
    }    
}
