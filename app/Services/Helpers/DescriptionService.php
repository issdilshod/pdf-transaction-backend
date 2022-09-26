<?php

namespace App\Services\Helpers;

use App\Http\Resources\Helpers\DescriptionResource;
use App\Models\Helpers\Description;
use App\Models\Helpers\DescriptionToDescriptionRule;
use Illuminate\Support\Facades\Config;

class DescriptionService {

    public function get_descriptions()
    {
        $descriptions = Description::where('status', Config::get('custom.status.active'))
                                        ->get();
        return DescriptionResource::collection($descriptions);
    }

    public function get_description(Description $description)
    {
        $description = new DescriptionResource($description);
        return $description;
    }

    public function create_description($description)
    {
        $exsist = Description::where('status', Config::get('custom.status.active'))
                                ->where('name', $description['name'])
                                ->first();
        if ($exsist==null){
            $created = Description::create($description);
            // create rules if exsist
            if (isset($description['rules'])){
                foreach($description['rules'] AS $key => $value):
                    DescriptionToDescriptionRule::create([
                        'description_id' => $created->id, 
                        'description_rule_id' => $value['id'],
                        'value' => $value['value']
                    ]);
                endforeach;
            }
            return new DescriptionResource($created);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function update_description($update, Description $description)
    {
        $exsist = Description::where('status', Config::get('custom.status.active'))
                                ->where('name', $description['name'])
                                ->where('id', '!=', $description->id)
                                ->first();
        if ($exsist==null){
            $description->update($update);
            // create rules if exsist
            if (isset($update['rules'])){
                foreach($update['rules'] AS $key => $value):
                    DescriptionToDescriptionRule::create([
                        'description_id' => $description->id, 
                        'description_rule_id' => $value['id'],
                        'value' => $value['value']
                    ]);
                endforeach;
            }
            // delete rules if exsist
            if (isset($update['rules_to_delete'])){
                foreach($update['rules_to_delete'] AS $key => $value):
                    $desc_to_descRule = DescriptionToDescriptionRule::where('id', $value);
                    $desc_to_descRule->update(['status' => Config::get('custom.status.delete')]);
                endforeach;
            }
            return new DescriptionResource($description);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function delete_description($description)
    {
        $description->update(['status' => Config::get('custom.status.delete')]);
    }
}