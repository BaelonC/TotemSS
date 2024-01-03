<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Smarty;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $smarty;
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $this->initSmarty();

    }
            /**
         * Inicializa smarty con la configuraciones definidas en namespace Config
         */
         private function initSmarty(){
         $configDirs = \Config\SmartyConfig::$configDirs;
         $this->smarty = new Smarty();
         $this->smarty->setTemplateDir($configDirs['templateDir']);
         $this->smarty->setCompileDir($configDirs['compileDir']);
         $this->smarty->setCacheDir($configDirs['cacheDir']);
         $this->smarty->setConfigDir($configDirs['configDir']); 
         }

         /**
         * implementa método para llamar a las vistas renderizadas con smarty
         * @param type $viewname
         * @param array $data; contiene los datos que estarán disponibles para 
         * smarty al momento de renderizar la vista.
         * @param type $mode ; un valor false indica retornar la vista como 
         * respuesta del server y true retornar como un string que puede ser enviado
         * al cliente por ejemplo mediante dentro de un mensaje json
         * @return type
         */
         protected function smartyView($viewname, array $data = [], $mode=False){
         $this->smarty->assign($data);
         if(!$mode){
         $this->smarty->display($this->smarty->getTemplateDir(0).$viewname.'.'. \
        Config\SmartyConfig::$fileExtension );
         }else{
         return $this->smarty->fetch($this->smarty->getTemplateDir(0).
        $viewname.'.'. \Config\SmartyConfig::$fileExtension );
         }

         }

}
