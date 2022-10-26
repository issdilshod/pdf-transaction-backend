<?php

namespace App\Helpers;

class LogHelper{

    public function to_file($entity){
        $f = fopen('logs/' . date('YmdHi') . '.txt', 'w');
        fwrite($f, print_r($entity, TRUE));
        fclose($f);
    }
    
}