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
            'content' => '',
            'font' => 'array'
        ]);

        $respond = $this->pdfContentService->hex2ascii($validated);

        return response()->json([
            'data' => $respond
        ], 200);
    }

    /**     @OA\POST(
      *         path="/api/hex2ascii/period",
      *         operationId="create_ascii_from_hex_period",
      *         tags={"Statements"},
      *         summary="Create ascii from hex period",
      *         description="Create ascii from hex period",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"replacement"},
      *                         @OA\Property(property="replacement")
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
    public function hex2ascii_period(Request $request)
    {
        $validated = $request->validate([
            'replacement' => 'array'
        ]);

        $respond = $this->pdfContentService->hex2asciiPeriod($validated);

        return response()->json([
            'data' => $respond
        ], 200);
    }

    /**     @OA\POST(
      *         path="/api/gzip/period",
      *         operationId="create_gzip_period",
      *         tags={"Statements"},
      *         summary="Create gzip period",
      *         description="Create gzip period",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"compression"},
      *                         @OA\Property(property="compression")
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
    public function gzip_period(Request $request)
    {
        $validated = $request->validate([
            'compression' => 'array'
        ]);

        $respond = $this->pdfContentService->gzipPeriod($validated);

        return response()->json([
            'data' => $respond
        ], 200);
    }

}
