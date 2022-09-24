<?php

namespace App\Services;

use App\Http\Resources\RangeResource;
use App\Models\Range;
use Illuminate\Support\Facades\Config;

class RangeService {

    public function get_ranges()
    {
        $ranges = Range::orderBy('created_at', 'ASC')
                        ->where('status', Config::get('custom.status.active'))
                        ->get();
        return RangeResource::collection($ranges);
    }

    public function get_range(Range $range)
    {
        $range = new RangeResource($range);
        return $range;
    }

    public function create_range($range)
    {
        $exsist = Range::where('status', Config::get('custom.status.active'))
                        ->where('start', $range['start'])
                        ->where('end', $range['end'])
                        ->first();
        if ($exsist==null){
            $created = Range::create($range);
            return new RangeResource($created);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function update_range($update, Range $range)
    {
        $exsist = Range::where('status', Config::get('custom.status.active'))
                        ->where('start', $update['start'])
                        ->where('end', $update['end'])
                        ->where('id', '!=', $range->id)
                        ->first();
        if ($exsist==null){
            $range->update($update);
            return new RangeResource($range);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function delete_range(Range $range)
    {
        $range->update(['status' => Config::get('custom.status.delete')]);
    }
}