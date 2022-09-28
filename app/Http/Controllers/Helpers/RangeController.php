<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Models\Helpers\Range;
use App\Services\Helpers\RangeService;
use Illuminate\Http\Request;

class RangeController extends Controller
{
    private $rangeService;

    /**
     * First init of controller
     * 
     * @return void
     */
    public function __construct()
    {
        $this->rangeService = new RangeService();
    }

    /**     @OA\GET(
      *         path="/api/range",
      *         operationId="get_ranges",
      *         tags={"Helpers"},
      *         summary="Get ranges",
      *         description="Get ranges",
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function index()
    {
        $ranges = $this->rangeService->get_ranges();
        return $ranges;
    }

    /**     @OA\POST(
      *         path="/api/range",
      *         operationId="create_range",
      *         tags={"Helpers"},
      *         summary="Create range",
      *         description="Create range",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"start", "end"},
      *                         @OA\Property(property="start", type="text"),
      *                         @OA\Property(property="end", type="text")
      *                     ),
      *                 ),
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *             @OA\Response(response=409, description="Conflict"),
      *     )
      */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'start' => 'required',
            'end' => 'required'
        ]);

        $response = $this->rangeService->create_range($validated);
        return $response;
    }

    /**     @OA\GET(
      *         path="/api/range/{id}",
      *         operationId="get_range",
      *         tags={"Helpers"},
      *         summary="Get range",
      *         description="Get range",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="range id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function show(Range $range)
    {
        $range = $this->rangeService->get_range($range);
        return $range;
    }

    /**     @OA\PUT(
      *         path="/api/range/{id}",
      *         operationId="update_range",
      *         tags={"Helpers"},
      *         summary="Update range",
      *         description="Update range",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="range id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={},
      *                         @OA\Property(property="start", type="text"),
      *                         @OA\Property(property="end", type="text")
      *                     ),
      *                 ),
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function update(Request $request, Range $range)
    {
        $validated = $request->validate([
            'start' => '',
            'end' => ''
        ]);

        $response = $this->rangeService->update_range($validated, $range);
        return $response;
    }

    /**     @OA\DELETE(
      *         path="/api/range/{id}",
      *         operationId="delete_range",
      *         tags={"Helpers"},
      *         summary="Delete range",
      *         description="Delete range",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="range id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function destroy(Range $range)
    {
        $this->rangeService->delete_range($range);
    }
}
