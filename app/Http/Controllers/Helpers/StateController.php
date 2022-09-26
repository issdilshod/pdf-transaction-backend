<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Helpers\StateResource;
use App\Models\Helpers\State;
use Illuminate\Support\Facades\Config;

class StateController extends Controller
{
    
    /**     @OA\GET(
      *         path="/api/state",
      *         operationId="get_states",
      *         tags={"Helpers"},
      *         summary="Get states",
      *         description="Get states",
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function index()
    {
        $states = State::orderBy('full_name', 'ASC')
                            ->where('status', Config::get('custom.status.active'))
                            ->get();
        return StateResource::collection($states);
    }
}
