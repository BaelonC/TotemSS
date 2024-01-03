<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of MarcaDto
 *
 * @author juan.urrutia
 */


namespace App\Libraries\Dto;
use  \App\Libraries\Dto;


class MarcaDto {
    
    private $id;
    private PersonaDto $oPersonaDto;
    private $id_destino;        
    private DestinoDto $oDestinoDto;
   
    public function getId() {
        return $this->id;
    }

    public function getOPersonaDto(): PersonaDto {
        return $this->oPersonaDto;
    }

    public function getId_destino() {
        return $this->id_destino;
    }

    public function getODestinoDto(): DestinoDto {
        return $this->oDestinoDto;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setOPersonaDto(PersonaDto $oPersonaDto): void {
        $this->oPersonaDto = $oPersonaDto;
    }

    public function setId_destino($id_destino): void {
        $this->id_destino = $id_destino;
    }

    public function setODestinoDto(DestinoDto $oDestinoDto): void {
        $this->oDestinoDto = $oDestinoDto;
    }
}
