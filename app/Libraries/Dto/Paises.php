<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Libraries\Dto;
use Pais;

/**
 * Description of Paises
 *
 * @author juan.urrutia
 */
class Paises {
    //put your code here
    private Pais $paises;
    
     function __construct() {
         $this->paises=[];
     }
    
    
    public function add(Pais $p_pais){
        $this->paises[]= $p_pais;
    }
    public function getPaisCodigo(Pais $p_pais){
        $respuesta=[];
       
        foreach($this->paises as $pais){
           if ($pais->getCODIGO()== $p_pais->getCODIGO()){
              $respuesta[]=$pais;       
           }
        }
        return $respuesta;
    }
    
    public function getPaises(){
        return $this->paises;
    }
}
