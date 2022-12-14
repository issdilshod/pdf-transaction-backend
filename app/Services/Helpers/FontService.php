<?php

namespace App\Services\Helpers;

use App\Models\Helpers\Font;
use Illuminate\Support\Facades\Config;

class FontService {

    /**
     * Create font and returns bool
     * 
     * @param   Array
     * @return  bool
     */
    public function create_font($font)
    {
        $created = Font::create($font);
        return true;
    }

    public function update_font($font)
    {
        $exsist = Font::where('status', Config::get('custom.status.active'))
                        ->where('font_group_id', $font['font_group_id'])
                        ->where('ascii', $font['ascii'])
                        ->first();
        if ($exsist==null){
            $created = Font::create($font);
            return true;
        }else{
            $exsist->update($font);
            return true;
        }
        return false;
    }

    public function delete_font($font_id)
    {
        $font = Font::where('status', Config::get('custom.status.active'))
                        ->where('id', $font_id);
        $font->update(['status' => Config::get('custom.status.delete')]);
    }

    public function delete_by_group($group_id){
        Font::where('font_group_id', $group_id)->update(['status' => Config::get('custom.status.delete')]);
    }
}