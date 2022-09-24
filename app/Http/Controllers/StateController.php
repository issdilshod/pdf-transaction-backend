<?php

namespace App\Http\Controllers;

use App\Http\Resources\StateResource;
use App\Models\State;
use Illuminate\Support\Facades\Config;

class StateController extends Controller
{
    
    /**     @OA\GET(
      *         path="/api/state",
      *         operationId="get_states",
      *         tags={"Helper"},
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
