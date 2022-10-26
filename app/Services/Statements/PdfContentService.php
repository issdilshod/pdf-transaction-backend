<?php

namespace App\Services\Statements;

use App\Helpers\LogHelper;

class PdfContentService{

    private $logHelper;

    public function __construct()
    {
        $this->logHelper = new LogHelper();   
    }

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
            $entity['replacement'][$key]['content'] = base64_decode($entity['replacement'][$key]['content']);
            foreach ($value['font'] AS $key1 => $value1):
                foreach ($value1['content'] AS $key2 => $value2):
                    if ($value2['hex']!=null){
                        $hexValue = $this->hex2binString($value2['hex']);
                        $entity['replacement'][$key]['font'][$key1]['content'][$key2]['ascii'] = base64_encode($hexValue);

                        // change content
                        $entity['replacement'][$key]['content'] = $this->changeAsciiOnContent($entity['replacement'][$key]['content'], $value2['text'], $hexValue, $value2['pos_on_content']);
                    }
                endforeach;
            endforeach;
            $entity['replacement'][$key]['content'] = base64_encode($entity['replacement'][$key]['content']);
        endforeach;

        return $entity;
    }

    public function gzipPeriod($entity){
        $result = [];
        foreach ($entity['compression'] as $key => $value):
            $tmpGzip = $value['content'];
            $tmpGzip = base64_decode($tmpGzip);
            $tmpGzip = gzcompress($tmpGzip);
            $tmpGzip = base64_encode($tmpGzip);
            $result[$key] = $tmpGzip;
        endforeach;
        return $result;
    }

    public function getPdfData($filename){
        $result = []; $count_page = 0; $startxref = ""; $xref = ""; $el_root = ""; $obj_ = ""; $tmp = ""; $tmp2 = "";
        
        $string = file_get_contents($filename);

        
        $startxref = $this->getSubstring($string, "startxref", " ");
        $xref = $this->getSubstring($string, "<</Size", ">>");
        $el_root = $this->getSubstring($xref, "Root", "R", 1);
        $obj_ = $this->getSubstring($el_root, " ", " ", 1);

        $obj_ = trim($obj_);
        $obj_ = $this->getSubstring($string, $obj_." 0 obj", "endobj");
        $obj_ = $this->getSubstring($obj_, "Pages", "R", 1);
        $obj_ = $this->getSubstring($obj_, " ", " ", 1);

        // get object pages
        $obj_ = trim($obj_);
        $obj_ = $this->getSubstring($string, $obj_." 0 obj", "endobj");

        // get count pages
        $tmp = $this->getSubstring($obj_, "Count", ">");
        $count_page = (int)$this->getSubstring($tmp, " ", ">", 0, false);

        // pages to array
        $tmp = $this->getSubstring($obj_, "[", "]");
        $tmp = str_replace("0", "", $tmp);
        $tmp = str_replace("R", "", $tmp);
        $tmp = str_replace("[", "", $tmp);
        $tmp = str_replace("]", "", $tmp);
        $tmp = str_replace("  ", " ", $tmp);
        $tmp = explode(" ", $tmp);

        foreach ($tmp AS $key => $value){
            if ($value!=""){
                $page_name = ""; $object_name = ""; $old_length = ""; $new_length = ""; 
                // get contents of pages
                $obj_ = trim($value);
                $obj_ = $this->getSubstring($string, $obj_." 0 obj", "endobj");

                // get content object number of pages
                $obj_ = $this->getSubstring($obj_, "/Contents", "R", 1);
                $obj_ = $this->getSubstring($obj_, " ", " ", 1);
                $obj_ = trim($obj_);
                $object_name = "Object " . $obj_;

                // get object of pages
                $obj_ = $this->getSubstring($string, $obj_." 0 obj", "endobj");

                $tmp2 = $this->getSubstring($obj_, "Length", ">");
                $old_length = (int)$this->getSubstring($tmp2, " ", ">", 0, false);

                $obj_ = $this->getSubstring($obj_, "stream", "endstream");

                $result[] = ["page_name"=>$page_name, "object_name"=>$object_name, "old_length"=>$old_length, "new_length"=>$new_length];
            }
        }
        
        return ['pdfTable' => $result, 'filename' => $filename];
    }

    private function hex2binString($string){
        $result = '';
        for ($i = 0; $i< strlen($string); $i+=2){
            $result .= hex2bin(substr($string, $i, 2));
        }
        return $result;
    }

    private function changeAsciiOnContent($content, $search, $replace, $position){

        $first_part = substr($content, 0, strpos($content, $search)); //strpos($content, $search, $position-10)
        $second_part = substr($content, strpos($content, $search)+strlen($search));

        $result = $first_part . '(' . $replace . ')Tj' . $second_part;

        return $result;
    }

    private function getSubstring($string, $s_string, $e_string, $special = 0, $end = true){
        $result = ""; $s_index = 0; $e_index = 0; $extra = strlen($e_string);
        if (!$end){$extra = 0;}
        $s_index = strpos($string, $s_string);
        $e_index = strpos($string, $e_string, $s_index+$special);
        $result = substr($string, $s_index, ($e_index-$s_index)+$extra);
        return $result;
    }

    private function getIndexBetween($string, $s_string, $e_string, $special = 0, $end = true){
        $result = []; $s_index = 0; $e_index = 0; $extra = strlen($e_string);
        if (!$end){$extra = 0;}
        $s_index = strpos($string, $s_string);
        $e_index = strpos($string, $e_string, $s_index+$special);
        $result['start_index'] = $s_index;
        $result['end_index'] = $e_index;
        $result['length_'] = strlen(strpos($string, $s_index, ($e_index-$s_index)+$extra));
        return $result;
    }

}