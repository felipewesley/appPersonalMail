<?php

namespace MiniFramework\Controller;

use stdClass; 
use MiniFramework\Model\Container; 

abstract class Action {

    protected $view; 

    public function __construct() {
        $this->view = new stdClass(); 
    }

    protected function model($modelName) {
        return Container::getModel($modelName); 
    }

    protected function render($view, $layout = null, $aditionFiles = []) {
        
        $this->view->page = $view; 
        
        if (is_array($aditionFiles) && (count($aditionFiles) > 0)) {
            foreach ($aditionFiles as $key => $value) {
                if (is_string($value) && is_string($key)) {
                    if ($key == 'css') {
                        $value.= !stripos($value, '.css') ? '.css' : '';
                        $css = "./css/$value"; 
                        if (!file_exists($css)) {
                            // 'June 24th, 2020'; 
                            $date = date('F jS, Y'); 
                            file_put_contents($css, '/* This stylesheet created in '.date('F jS, Y').'. */'); 
                        }
                        $this->view->css = $css; 
                        continue; 
                    }
                    if ($key == 'js') {
                        $value.= !stripos($value, '.js') ? '.js' : '';
                        $js = "./js/$value"; 
                        if (!file_exists($js)) {
                            file_put_contents($js, '/* This script file created in '.date('F jS, Y').'. */'); 
                        }
                        $this->view->js = $js; 
                        continue; 
                    }
                    Debug::show('Valor passado para $aditionalFiles é incorreto.'); 
                }
            }
        }
        
        $urlView = "../App/View/layout/$layout.phtml"; 
        if(is_null($layout) || !file_exists($urlView)){
            return $this->content(); 
        }
        
        return require_once $urlView; 
    }

    private function content() {
        
        $atualClass = str_replace('App\\Controller\\', '', get_class($this)); 
        $directory = strtolower(str_replace('Controller', '', $atualClass)); 
        
        require_once "../App/View/$directory/{$this->view->page}.phtml"; 
    }

}