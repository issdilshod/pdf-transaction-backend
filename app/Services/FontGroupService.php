<?php

namespace App\Services;

use App\Http\Resources\FontGroupResource;
use App\Models\FontGroup;
use Illuminate\Support\Facades\Config;

class FontGroupService {

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