<?php

namespace App\Services\Statements;

class PdfContentService{

    public function hex2ascii($entity){

        $entity['content'] = base64_decode($entity['content']);
        foreach ($entity['font'] AS $key => $value):
            foreach ($value['content'] AS $key1 => $value1):
                if ($value1['hex']!=null){
                    $hexValue = $this->hex2binString($value1['hex']);
                    $entity['font'][$key]['content'][$key1]['ascii'] = base64_encode($hexValue);

                    // change content
                    $entity['content'] = $this->changeAsciiOnContent($entity['content'], $value1['text'], $hexValue, $value1['pos_on_content']);
                }
            endforeach;
        endforeach;
        $entity['content'] = base64_encode($entity['content']);

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

    private function changeAsciiOnContent($content, $search, $replace, $position){

        $first_part = substr($content, 0, strpos($content, $search, $position-1));
        $second_part = substr($content, strpos($content, $search, $position-1)+strlen($search));

        $result = $first_part . '(' . $replace . ')Tj' . $second_part;

        return $result;
    }

}