<?php

/**
 * @author Felipe Wesley 
 * @link https://github.com/felipewesley/MiniFrameworkPHP
 */

// Namespace definido de acordo com a especificação PSR-4
namespace App; 

use MiniFramework\Init\Bootstrap; 

class Route extends Bootstrap {

    protected function initRoutes(){

        $file = 'config/routes.ini'; 
        $routes = parse_ini_file($file, true); 

        return $this->setRoutes($routes); 
    }

}