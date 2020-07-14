<?php

namespace MiniFramework\Init;

use App\Controller\PersonalMailController;

abstract class Bootstrap {

    private $routes;

    public function __construct(){
        $this->initRoutes();
        $this->run($this->getUrl());
    }

    abstract protected function initRoutes();

    public function getRoutes(){
        return $this->routes;
    }

    public function setRoutes(array $routes){
        $this->routes = $routes;
    }

    protected function getUrl(){
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    protected function run($url){

        foreach ($this->getRoutes() as $route) {
            if ($url == $route['route']) {
                $class = 'App\\Controller\\'.ucfirst($route['controller']);
                $controller = new $class;
                $action = $route['action'];
                return $controller->$action();
            }
        }
        $c = new PersonalMailController();
        return $c->index();
    }
}
