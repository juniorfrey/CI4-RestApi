<?php

namespace App\Libraries;
class Conexionbd {
    
    public function conectar($dbnombre){
        $db = \Config\Database::connect();
        $db->setDatabase($dbnombre);
        return $db;
    }
}