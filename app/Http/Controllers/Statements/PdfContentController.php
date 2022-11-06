<?php

namespace App\Http\Controllers\Statements;

use App\Http\Controllers\Controller;
use App\Models\Helpers\PdfTemplate;
use App\Services\Statements\PdfContentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    /**     @OA\POST(
      *         path="/api/upload/template",
      *         operationId="Upload template",
      *         tags={"Statements"},
      *         summary="Upload pdf template",
      *         description="Upload pdf template",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"template"},
      *                         @OA\Property(property="template")
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
    public function upload_template(Request $request)
    {
        if ($request->has('template')){
            $templateFile = $request->file('template');
            $fileName = Str::uuid()->toString() . '.' . $templateFile->getClientOriginalExtension();
            $templateFile->move('uploads', $fileName);

            $respond = $this->pdfContentService->getPdfData('uploads/'.$fileName);

            return response()->json([
                'data' => $respond
            ], 200);

        }

        return response()->json([
            'error' => 'Choose the file'
        ], 422);
    }

    /**     @OA\GET(
      *         path="/api/use/template/{template_id}",
      *         operationId="Use template",
      *         tags={"Statements"},
      *         summary="Use pdf template",
      *         description="Use pdf template",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="template id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *             @OA\Response(response=409, description="Conflict"),
      *     )
      */
    public function use_template(Request $request, $template_id)
    {
        $pdfTemplate = PdfTemplate::where('id', $template_id)->first();

        $respond = $this->pdfContentService->getPdfData('statements/templates/'.$pdfTemplate->file_path);

        return response()->json([
            'data' => $respond
        ], 200);
    }

    /**     @OA\POST(
      *         path="/api/pdf/change",
      *         operationId="change_pdf_content_pages",
      *         tags={"Statements"},
      *         summary="Change pdf content pages",
      *         description="Change pdf content pages",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"filename", "compression"},
      *                         @OA\Property(property="filename"),
      *                         @OA\Property(property="compression"),
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
    public function pdf_change(Request $request)
    {
        $validated = $request->validate([
            'filename' => 'required',
            'pdf' => 'array',
            'compression' => 'array'
        ]);

        $respond = $this->pdfContentService->changePdfPages($validated);
        $respond = $this->pdfContentService->changePdfXref($respond);

        // create pdf file
        $filename = 'statements/' . Str::uuid()->toString() . '.pdf';
        $f = fopen($filename, 'w');
        fwrite($f, $respond);
        fclose($f);

        return $filename;
    }

}
