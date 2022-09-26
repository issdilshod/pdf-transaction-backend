<?php

namespace App\Http\Controllers;

use App\Models\Description;
use App\Services\DescriptionService;
use Illuminate\Http\Request;

class DescriptionController extends Controller
{
    private $descriptionService;

    public  function __construct()
    {
        $this->descriptionService = new DescriptionService();
    }

    /**     @OA\GET(
      *         path="/api/description",
      *         operationId="get_descriptions",
      *         tags={"Description"},
      *         summary="Get descriptions",
      *         description="Get descriptions",
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function index()
    {
        $descriptions = $this->descriptionService->get_descriptions();
        return $descriptions;
    }

    /**     @OA\POST(
      *         path="/api/description",
      *         operationId="create_description",
      *         tags={"Description"},
      *         summary="Create description",
      *         description="Create description",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"name"},
      *                         @OA\Property(property="name", type="text"),
      *                         @OA\Property(property="description", type="text"),
      *                         @OA\Property(property="split", type="text"),
      *                         @OA\Property(property="rules[][id]", type="text"),
      *                         @OA\Property(property="rules[][value]", type="text")
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
            'description' => '',
            'split' => '',
            'rules' => ''
        ]);

        $response = $this->descriptionService->create_description($validated);
        return $response;
    }

    /**     @OA\GET(
      *         path="/api/description/{id}",
      *         operationId="get_description",
      *         tags={"Description"},
      *         summary="Get description",
      *         description="Get description",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="description id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function show(Description $description)
    {
        $description = $this->descriptionService->get_description($description);
        return $description;
    }

    /**     @OA\PUT(
      *         path="/api/description/{id}",
      *         operationId="update_description",
      *         tags={"Description"},
      *         summary="Update description",
      *         description="Update description",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="description id",
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
      *                         @OA\Property(property="description", type="text"),
      *                         @OA\Property(property="split", type="integer"),
      *                         @OA\Property(property="rules[][id]", type="text"),
      *                         @OA\Property(property="rules[][value]", type="text"),
      *                         @OA\Property(property="rules_to_delete[]", type="text"),
      *                     ),
      *                 ),
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function update(Request $request, Description $description)
    {
        $validated = $request->validate([
            'name' => '',
            'description' => '',
            'split' => '',
            'rules' => '',
            'rules_to_delete' => ''
        ]);

        $response = $this->descriptionService->update_description($validated, $description);
        return $response;
    }

    /**     @OA\DELETE(
      *         path="/api/description/{id}",
      *         operationId="delete_description",
      *         tags={"Description"},
      *         summary="Delete description",
      *         description="Delete description",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="font description",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function destroy(Description $description)
    {
        $this->descriptionService->delete_description($description);
    }
}
