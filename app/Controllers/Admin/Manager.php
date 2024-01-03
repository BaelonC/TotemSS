<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\TiposDoctoIdentificacion;
/**
 * Description of Manager
 *
 * @author fernando.garcia
 */
class Manager extends BaseController{
    //put your code here
    
    private $sesion;
    private TiposDoctoIdentificacion $oTiposDoctoIdentificacion;
    
    public function __construct() {
        $this->sesion = $session = \Config\Services::session();
        $this->oTiposDoctoIdentificacion = new TiposDoctoIdentificacion();
    }    
    
    public function CrearProgramadorDestinosAncud(){
        
        
    }
}
