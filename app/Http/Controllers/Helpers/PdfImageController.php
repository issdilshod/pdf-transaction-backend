<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Models\Helpers\PdfImage;
use App\Services\Helpers\PdfImageService;
use Illuminate\Http\Request;

class PdfImageController extends Controller
{

    private $pdfImageService;

    public function __construct()
    {
        $this->pdfImageService = new PdfImageService();
    }
    
    /**     @OA\GET(
      *         path="/api/pdf-image",
      *         operationId="get_pdf_images",
      *         tags={"Helpers"},
      *         summary="Get pdf image",
      *         description="Get pdf image",
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function index()
    {
        $pdfImage = $this->pdfImageService->all();
        return $pdfImage;
    }

    /**     @OA\POST(
      *         path="/api/pdf-image",
      *         operationId="create_pdf_image",
      *         tags={"Helpers"},
      *         summary="Create pdf image",
      *         description="Create pdf image",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"period"},
      *                         @OA\Property(property="period", type="date"),
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
            'period' => 'required'
        ]);

        $response = $this->pdfImageService->create($validated);
        return $response;
    }

    /**     @OA\GET(
      *         path="/api/pdf-image/{id}",
      *         operationId="get_pdf_image",
      *         tags={"Helpers"},
      *         summary="Get pdf image",
      *         description="Get pdf image",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="pdf image id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function show(PdfImage $pdfImage)
    {
        $pdfImage = $this->pdfImageService->get($pdfImage);
        return $pdfImage;
    }

    /**     @OA\PUT(
      *         path="/api/pdf-image/{id}",
      *         operationId="update_pdf_image",
      *         tags={"Helpers"},
      *         summary="Update pdf image",
      *         description="Update pdf image",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="pdf image id",
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
      *                         @OA\Property(property="period", type="text"),
      *                     ),
      *                 ),
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function update(Request $request, PdfImage $pdfImage)
    {
        $validated = $request->validate([
            'period' => ''
        ]);

        $response = $this->pdfImageService->update($validated, $pdfImage);
        return $response;
    }

    /**     @OA\DELETE(
      *         path="/api/pdf-image/{id}",
      *         operationId="delete_pdf_image",
      *         tags={"Helpers"},
      *         summary="Delete pdf image",
      *         description="Delete pdf image",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="pdf image id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function destroy(PdfImage $pdfImage)
    {
        $this->pdfImageService->delete($pdfImage);
    }
}
