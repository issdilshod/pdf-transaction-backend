<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Models\Helpers\PdfTemplate;
use App\Services\Helpers\PdfTemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PdfTemplateController extends Controller
{
    
    private $pdfTemplateService;

    public function __construct()
    {
        $this->pdfTemplateService = new PdfTemplateService();
    }

    /**     @OA\GET(
      *         path="/api/pdf-template",
      *         operationId="get_pdf_templates",
      *         tags={"Helpers"},
      *         summary="Get pdf templates",
      *         description="Get pdf templates",
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function index()
    {
        $pdfTemplate = $this->pdfTemplateService->all();
        return $pdfTemplate;
    }
  
    /**     @OA\POST(
      *         path="/api/pdf-template",
      *         operationId="create_pdf_template",
      *         tags={"Helpers"},
      *         summary="Create pdf template",
      *         description="Create pdf template",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"period", "name", "file"},
      *                         @OA\Property(property="period", type="date"),
      *                         @OA\Property(property="name", type="date"),
      *                         @OA\Property(property="file", type="binary"),
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
            'period' => 'required',
            'name' => 'required'
        ]);

        // check if file exists
        if (!$request->has('file')){
            return response()->json([
                'msg' => 'Choose Template file'
            ], 422);
        }

        $templateFile = $request->file('file');
        $fileName = Str::uuid()->toString() . '.' . $templateFile->getClientOriginalExtension();
        $templateFile->move('statements/templates', $fileName);

        // get file data
        $validated['file_path'] = $fileName;
        $validated['file_name'] = $templateFile->getClientOriginalName();

        $response = $this->pdfTemplateService->create($validated);
        return $response;
    }
  
    /**     @OA\GET(
      *         path="/api/pdf-template/{id}",
      *         operationId="get_pdf_template",
      *         tags={"Helpers"},
      *         summary="Get pdf template",
      *         description="Get pdf template",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="pdf template id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function show(PdfTemplate $pdfTemplate)
    {
        $pdfTemplate = $this->pdfTemplateService->get($pdfTemplate);
        return $pdfTemplate;
    }
  
    /**     @OA\PUT(
      *         path="/api/pdf-template/{id}",
      *         operationId="update_pdf_template",
      *         tags={"Helpers"},
      *         summary="Update pdf template",
      *         description="Update pdf template",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="pdf template id",
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
      *                         @OA\Property(property="name", type="text"),
      *                         @OA\Property(property="file", type="binary"),
      *                     ),
      *                 ),
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function update(Request $request, PdfTemplate $pdfTemplate)
    {
        $validated = $request->validate([
            'period' => '',
            'name' => ''
        ]);

        if ($request->has('file')){
            $templateFile = $request->file('file');
            $fileName = Str::uuid()->toString() . '.' . $templateFile->getClientOriginalExtension();
            $templateFile->move('statements/templates', $fileName);

            // get file data
            $validated['file_path'] = $fileName;
            $validated['file_name'] = $templateFile->getClientOriginalName();
        }

        $response = $this->pdfTemplateService->update($validated, $pdfTemplate);
        return $response;
    }
  
    /**     @OA\DELETE(
      *         path="/api/pdf-template/{id}",
      *         operationId="delete_pdf_template",
      *         tags={"Helpers"},
      *         summary="Delete pdf template",
      *         description="Delete pdf template",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="pdf template id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function destroy(PdfTemplate $pdfTemplate)
    {
        $this->pdfTemplateService->delete($pdfTemplate);
    }
}
