<?php

namespace App\Services\Helpers;

use App\Http\Resources\Helpers\FontGroupResource;
use App\Models\Helpers\FontGroup;
use Illuminate\Support\Facades\Config;

class FontGroupService {

    private $fontService;

    public function __construct()
    {
        $this->fontService = new FontService();
    }

    public function get_fontGroups()
    {
        $fontGroups = FontGroup::orderBy('created_at', 'DESC')
                                ->where('status', Config::get('custom.status.active'))
                                ->get();
        return FontGroupResource::collection($fontGroups);
    }

    public function get_fontGroup(FontGroup $fontGroup)
    {
        $fontGroup = new FontGroupResource($fontGroup);
        return $fontGroup;
    }

    public function create_fontGroup($fontGroup)
    {
        $exsist = FontGroup::where('status', Config::get('custom.status.active'))
                                ->where('name', $fontGroup['name'])
                                ->first();
        if ($exsist==null){
            $created = FontGroup::create($fontGroup);
            // create fonts if exsist
            if (isset($fontGroup['font'])){
                foreach($fontGroup['font'] AS $key => $value):
                    $value['font_group_id'] = $created->id;
                    $font = $this->fontService->create_font($value);
                endforeach;
            }
            return new FontGroupResource($created);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function update_fontGroup($update, FontGroup $fontGroup)
    {
        $exsist = FontGroup::where('status', Config::get('custom.status.active'))
                            ->where('name', $update['name'])
                            ->where('id', '!=', $fontGroup->id)
                            ->first();
        if ($exsist==null){
            $fontGroup->update($update);
            // create/update fonts if exsist
            if (isset($update['font'])){
                $this->fontService->delete_by_group($fontGroup->id);
                foreach($update['font'] AS $key => $value):
                    $value['font_group_id'] = $fontGroup->id;
                    $font = $this->fontService->update_font($value);
                endforeach;
            }
            return new FontGroupResource($fontGroup);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function delete_fontGroup(FontGroup $fontGroup)
    {
        $fontGroup->update(['status' => Config::get('custom.status.delete')]);
    }
}