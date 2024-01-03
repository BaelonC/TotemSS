<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to 
change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit 
this template
 */
namespace Config;
/**
 * Description of SmartyConfig
 *
 * @author fgarcia
 * 
 * Define los parametros principales de configuración del motor de template Smarty
 * 
 */
class SmartyConfig {
 public static $configDirs =[
 'templateDir'=> APPPATH.'Views',
 'compileDir'=> APPPATH.'Templates_c',
 'cacheDir' => APPPATH.'Cache',
 'configDir' => APPPATH.'Config'
 ];
 
 public static $fileExtension = 'tpl';
}
