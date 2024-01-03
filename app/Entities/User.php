<?php namespace App\Entities;

use CodeIgniter\Entity;

class User extends Entity

{
    
    public function __construct(?array $data = null){
        parent::__construct($data);
    }
    
    public function separador_rut($run){
    
        $this->attributes['RUT'] = explode("-",$run)[0];
        $this->attributes['DV'] = explode("-",$run)[1];
        
    }
}
