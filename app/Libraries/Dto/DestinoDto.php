<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of DestinoDto
 *
 * @author juan.urrutia
 */

namespace App\Libraries\Dto;
class DestinoDto {
    //put your code here
 
  
    private $id;
    private $sala;
    private $piso;
    private $id_establecimiento;
    
    public function getId() {
        return $this->id;
    }

    public function getSala() {
        return $this->sala;
    }

    public function getPiso() {
        return $this->piso;
    }

    public function getId_establecimiento() {
        return $this->id_establecimiento;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setSala($sala): void {
        $this->sala = $sala;
    }

    public function setPiso($piso): void {
        $this->piso = $piso;
    }

    public function setId_establecimiento($id_establecimiento): void {
        $this->id_establecimiento = $id_establecimiento;
    }
}

