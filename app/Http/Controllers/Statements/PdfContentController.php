<?php

namespace App\Http\Controllers\Statements;

use App\Http\Controllers\Controller;
use App\Services\Statements\PdfContentService;
use Illuminate\Http\Request;

class PdfContentController extends Controller
{
    private $pdfContentService;

    public function __construct()
    {
        $this->pdfContentService = new PdfContentService();
    }
    
    /**     @OA\POST(
      *         path="/api/hex2ascii",
      *         operationId="create_ascii_from_hex",
      *         tags={"Statements"},
      *         summary="Create ascii from hex",
      *         description="Create ascii from hex",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"font"},
      *                         @OA\Property(property="font")
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
    public function hex2ascii(Request $request)
    {
        $validated = $request->validate([
            'font' => 'array'
        ]);

        $respond = $this->pdfContentService->hex2ascii($validated);

        return response()->json([
            'data' => $respond
        ], 200);
    }

}
