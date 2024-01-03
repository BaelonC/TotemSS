<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Libraries\Dto;

/**
 * Description of EstablecimientoDto
 *
 * @author juan.urrutia
 */
class EstablecimientoDto {
    //put your code here
    private $id_establecimiento;
    private $nombre;
    private $host;
    
    public function getId_establecimiento() {
        return $this->id_establecimiento;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getHost() {
        return $this->host;
    }

    public function setId_establecimiento($id_establecimiento): void {
        $this->id_establecimiento = $id_establecimiento;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setHost($host): void {
        $this->host = $host;
    }
 
}
