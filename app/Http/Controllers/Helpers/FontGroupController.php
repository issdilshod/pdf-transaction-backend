<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Models\Helpers\FontGroup;
use App\Services\Helpers\FontGroupService;
use Illuminate\Http\Request;

class FontGroupController extends Controller
{
    private $fontGroupService;

    public  function __construct()
    {
        $this->fontGroupService = new FontGroupService();
    }

    /**     @OA\GET(
      *         path="/api/font-group",
      *         operationId="get_fontGroups",
      *         tags={"Helpers"},
      *         summary="Get font groups",
      *         description="Get font groups",
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function index()
    {
        $fontGroups = $this->fontGroupService->get_fontGroups();
        return $fontGroups;
    }

    /**     @OA\POST(
      *         path="/api/font-group",
      *         operationId="create_fontGroup",
      *         tags={"Helpers"},
      *         summary="Create font group",
      *         description="Create font group",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"name"},
      *                         @OA\Property(property="name", type="text"),
      *                         @OA\Property(property="font[][ascii]", type="text"),
      *                         @OA\Property(property="font[][unicode]", type="text"),
      *                         @OA\Property(property="font[][hex]", type="text"),
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
            'font' => ''
        ]);

        $response = $this->fontGroupService->create_fontGroup($validated);
        return $response;
    }

    /**     @OA\GET(
      *         path="/api/font-group/{id}",
      *         operationId="get_fontGroup",
      *         tags={"Helpers"},
      *         summary="Get font group",
      *         description="Get font group",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="font group id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function show(FontGroup $fontGroup)
    {
        $fontGroup = $this->fontGroupService->get_fontGroup($fontGroup);
        return $fontGroup;
    }

    /**     @OA\PUT(
      *         path="/api/font-group/{id}",
      *         operationId="update_fontGroup",
      *         tags={"Helpers"},
      *         summary="Update font group",
      *         description="Update font group",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="font group id",
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
      *                         @OA\Property(property="font[][ascii]", type="text"),
      *                         @OA\Property(property="font[][unicode]", type="text"),
      *                         @OA\Property(property="font[][hex]", type="text"),
      *                         @OA\Property(property="font_to_delete[]", type="text")
      *                     ),
      *                 ),
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function update(Request $request, FontGroup $fontGroup)
    {
        $validated = $request->validate([
            'name' => '',
            'font' => '',
            'font_to_delete' => ''
        ]);

        $response = $this->fontGroupService->update_fontGroup($validated, $fontGroup);
        return $response;
    }

    /**     @OA\DELETE(
      *         path="/api/font-group/{id}",
      *         operationId="delete_fontGroup",
      *         tags={"Helpers"},
      *         summary="Delete font group",
      *         description="Delete font group",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="font group id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function destroy(FontGroup $fontGroup)
    {
        $this->fontGroupService->delete_fontGroup($fontGroup);
    }
}
