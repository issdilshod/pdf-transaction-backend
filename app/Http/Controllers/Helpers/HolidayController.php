<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Models\Helpers\Holiday;
use App\Services\Helpers\HolidayService;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    private $holidayService;

    public  function __construct()
    {
        $this->holidayService = new HolidayService();
    }

    /**     @OA\GET(
      *         path="/api/holiday",
      *         operationId="get_holidays",
      *         tags={"Helpers"},
      *         summary="Get holidays",
      *         description="Get holidays",
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function index()
    {
        $holidays = $this->holidayService->get_holidays();
        return $holidays;
    }

    /**     @OA\POST(
      *         path="/api/holiday",
      *         operationId="create_holiday",
      *         tags={"Helpers"},
      *         summary="Create holiday",
      *         description="Create holiday",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"name", "date"},
      *                         @OA\Property(property="name", type="text"),
      *                         @OA\Property(property="date", type="date"),
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
            'name' => 'required',
            'date' => 'required'
        ]);

        $response = $this->holidayService->create_holiday($validated);
        return $response;
    }

    /**     @OA\GET(
      *         path="/api/holiday/{id}",
      *         operationId="get_holiday",
      *         tags={"Helpers"},
      *         summary="Get holiday",
      *         description="Get holiday",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="holiday id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function show(Holiday $holiday)
    {
        $holiday = $this->holidayService->get_holiday($holiday);
        return $holiday;
    }

    /**     @OA\PUT(
      *         path="/api/holiday/{id}",
      *         operationId="update_holiday",
      *         tags={"Helpers"},
      *         summary="Update holiday",
      *         description="Update holiday",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="holiday id",
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
      *                         @OA\Property(property="name", type="text"),
      *                         @OA\Property(property="date", type="date"),
      *                     ),
      *                 ),
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function update(Request $request, Holiday $holiday)
    {
        $validated = $request->validate([
            'name' => '',
            'date' => ''
        ]);

        $response = $this->holidayService->update_holiday($validated, $holiday);
        return $response;
    }

    /**     @OA\DELETE(
      *         path="/api/holiday/{id}",
      *         operationId="delete_holiday",
      *         tags={"Helpers"},
      *         summary="Delete holiday",
      *         description="Delete holiday",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="holiday id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function destroy(Holiday $holiday)
    {
        $this->holidayService->delete_holiday($holiday);
    }
}
