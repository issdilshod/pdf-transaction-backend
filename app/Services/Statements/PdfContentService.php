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
                if ($value1['hex']!=null && $value1['hex']!=''){
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
                    if ($value2['hex']!=null && $value2['hex']!=''){
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

    public function changePdfPages($entity){
        $obj_ = ""; $tmp = ""; $tmp2 = []; $tmp_arr = []; $i = 0;

        $string = file_get_contents($entity['filename']);

        $result = $string;
        foreach($entity['pdf'] AS $key => $value){
            $tmp2 = explode(" ", $value['object_name']);

            // get object in glob string
            $obj_ = $this->getSubstring($result, trim($tmp2[1])." 0 obj", "endobj");
            $tmp = $this->getSubstring($obj_, "Length", ">");

            // get length and change length data
            $tmp_arr = $this->getIndexBetween($tmp, " ", ">", 0, false);
            $tmp = substr($tmp, 0, $tmp_arr['start_index']+1) . $value['new_length'] . substr($tmp, $tmp_arr['end_index']);

            // set to object
            $tmp_arr = $this->getIndexBetween($obj_, "Length", ">", 0, false);
            $obj_ = "\n" . substr($obj_, 0, $tmp_arr['start_index']) . $tmp . substr($obj_, $tmp_arr['end_index']+1) . "\n";

            // get data of content and change
            $tmp_arr = $this->getIndexBetween($obj_, "stream", "endstream", 0, false);
            $obj_ = substr($obj_, 0, $tmp_arr['start_index']-1) . "\nstream\n" . base64_decode($entity['compression'][$i]) . "\nendstream" . substr($obj_, $tmp_arr['end_index']+9);

            // set to glob string
            $tmp_arr = $this->getIndexBetween($result, trim($tmp2[1])." 0 obj", "endobj");
            $result = substr($result, 0, $tmp_arr['start_index']-1) . $obj_ . substr($result, $tmp_arr['end_index']+7);
            $i++;
        }

        return $result;
    }

    public function changePdfXref($entity){
        $result = array(); $string_res = "";

        $string = $entity;

        $j= 0; $tmp = 0; $number = ""; $pos = 0;
        // while object not done
        while (strpos($string, " 0 obj", $pos+(1+strlen($number)))!=""){
            $tmp = strpos($string, " 0 obj", $pos+1+strlen($number));
        
            $pos = $tmp;
            // find first number
            $s_p = 0; $number = "";
            for ($i = $tmp-1; $i > 0; $i--) {
                if (is_numeric(substr($string, $i, 1))){
                    $s_p = $i;
                    $number = substr($string, $i, 1) . $number;
                }else{
                    break;
                }
            }
            // poi
            $tmp = $s_p;
            // hex
            $tmp = strtolower(dechex($tmp));
            $hex = $tmp;
            // tw
            $tmp = $tmp . "00";
            while (strlen($tmp)<10){
                $tmp = "0" . $tmp;
            }
            $tmp = "01" . $tmp;
            $tw = $tmp;
            $result[] = array("obj"=>(int)$number, "poi"=>$s_p, "hex"=>$hex, "tw"=>$tw);
            $j++;
        }
        // sort
        $sort = array_column($result, 'obj'); 
        array_multisort($sort, SORT_ASC, $result);
        // one line
        foreach($result AS $key => $value){
            $string_res .= $value['tw'];
        }
        $string_res = "0000000000ff" . $string_res;
        
        // bin2
        $string_res = $this->hex2binString($string_res);
        
        // gzcompress
        $tmp_data = gzcompress($string_res);

        $result_x = $this->changePdfXrefIn($string, $tmp_data);

        return $result_x;
    }

    private function changePdfXrefIn($string, $xref){
        $index = strpos($string, "/XRef");
        $start_obj = 0; $end_obj = 0;
        // find object
        for ($i = $index; $i > 0; $i--) {
            if (substr($string, $i, 6)=="endobj"){
                $start_obj = $i + 7;
                break;
            }
        }
        $end_obj = strpos($string, "endobj", $start_obj);
        $end_obj_pos = $end_obj + 7;
        $tmp_obj = substr($string, $start_obj, $end_obj - $start_obj + 6);

        // set new data
        $tmp = $this->getSubstring($tmp_obj, "Length", ">");

        // get length and change length data
        $tmp_arr = $this->getIndexBetween($tmp, " ", ">", 0, false);
        $tmp = substr($tmp, 0, $tmp_arr['start_index']+1) . strlen($xref) . substr($tmp, $tmp_arr['end_index']);

        // set to object
        $tmp_arr = $this->getIndexBetween($tmp_obj, "Length", ">", 0, false);
        $tmp_obj = "\n" . substr($tmp_obj, 0, $tmp_arr['start_index']) . $tmp . substr($tmp_obj, $tmp_arr['end_index']+1) . "\n";

        // get data of content and change
        $tmp_arr = $this->getIndexBetween($tmp_obj, "stream", "endstream", 0, false);
        $tmp_obj = substr($tmp_obj, 0, $tmp_arr['start_index']-1) . "\nstream\n" . $xref . "\nendstream" . substr($tmp_obj, $tmp_arr['end_index']+9);
        // set to glob string
        $string = substr($string, 0, $start_obj-1) . $tmp_obj . substr($string, $end_obj_pos);

        // EOF number
        $eof = $start_obj;
        $eofpos = strpos($string, "startxref");
        $eofpos1 = strpos($string, "%%EOF");
        $string = substr($string, 0, $eofpos+9) . "\n" . $eof . "\n" . substr($string, $eofpos1);

        return $string;
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