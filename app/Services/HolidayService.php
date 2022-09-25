<?php

namespace App\Services;

use App\Http\Resources\HolidayResource;
use App\Models\Holiday;
use Illuminate\Support\Facades\Config;

class HolidayService {

    public function get_holidays()
    {
        $holiday = Holiday::orderBy('date', 'ASC')
                                    ->where('status', Config::get('custom.status.active'))
                                    ->get();
        return HolidayResource::collection($holiday);
    }

    public function get_holiday(Holiday $holiday)
    {
        $holiday = new HolidayResource($holiday);
        return $holiday;
    }

    public function create_holiday($holiday)
    {
        $exsist = Holiday::where('status', Config::get('custom.status.active'))
                                ->where('date', $holiday['date'])
                                ->first();
        if ($exsist==null){
            $created = Holiday::create($holiday);
            return new HolidayResource($created);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function update_holiday($update, Holiday $holiday)
    {
        $exsist = Holiday::where('status', Config::get('custom.status.active'))
                            ->where('date', $update['date'])
                            ->where('id', '!=', $holiday->id)
                            ->first();
        if ($exsist==null){
            $holiday->update($update);
            return new HolidayResource($holiday);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function delete_holiday(Holiday $holiday)
    {
        $holiday->update(['status' => Config::get('custom.status.delete')]);
    }
}