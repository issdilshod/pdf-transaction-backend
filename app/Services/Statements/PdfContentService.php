<?php

namespace App\Services\Statements;

class PdfContentService{

    public function hex2ascii($entity){

        foreach ($entity['font'] AS $key => $value):
            foreach ($value['content'] AS $key1 => $value1):
                if ($value1['hex']!=null){
                    $entity['font'][$key]['content'][$key1]['ascii'] = base64_encode($this->hex2binString($value1['hex']));
                }
            endforeach;
        endforeach;

        return $entity;
    }

    public function hex2asciiPeriod($entity){

        foreach ($entity['replacement'] as $key => $value):
            foreach ($value['font'] AS $key1 => $value1):
                foreach ($value1['content'] AS $key2 => $value2):
                    if ($value2['hex']!=null){
                        $entity['replacement'][$key]['font'][$key1]['content'][$key2]['ascii'] = base64_encode($this->hex2binString($value2['hex']));
                    }
                endforeach;
            endforeach;
        endforeach;

        return $entity;
    }

    private function hex2binString($string){
        $result = '';
        for ($i = 0; $i< strlen($string); $i+=2){
            $result .= hex2bin(substr($string, $i, 2));
        }
        return $result;
    }

}