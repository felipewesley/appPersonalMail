<?php

/**
 * @author Felipe Wesley
 * Classe responsável por operações de debug do programa
 */

namespace MiniFramework\Controller; 

abstract class Debug {

    /**
     * @param mixed $content Conteúdo que deseja debugar/visualizar
     * @param boolean $die false deve ser passado para continuar a execução do programa
     * @return void
     */
    public static function show($content, $die = true) {
        
        echo '<div style="
                border: 1px solid #000; 
                background: #000; 
                color: #FFF; 
                padding: 5px; 
                margin: 5px; ">
            '; 
        if(is_string($content) || is_numeric($content)){
            echo $content; 
        } else {
            echo '<pre>'; 
            print_r($content); 
            echo '</pre>'; 
        }
        if($die){
            die('<br><br><small>Operação finalizada.</small>'); 
        }
        echo '</div>'; 

    }
}