<?php

namespace MiniFramework\Model; 

use App\Connection;

class Container {

    public static function getModel($model) {
        
        $class = '\\App\\Model\\'.ucfirst($model); 

        return new $class(Connection::getDb()); 
    }
}