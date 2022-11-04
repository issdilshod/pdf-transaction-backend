<?php

namespace App\Services\Helpers;

use App\Http\Resources\Helpers\PdfTemplateResource;
use App\Models\Helpers\PdfTemplate;
use Illuminate\Support\Facades\Config;

class PdfTemplateService{

    public function all()
    {
        $pdfTemplate = PdfTemplate::orderBy('period', 'DESC')
                                    ->where('status', Config::get('custom.status.active'))
                                    ->get();
        return PdfTemplateResource::collection($pdfTemplate);
    }

    public function get(PdfTemplate $pdfTemplate)
    {
        $pdfTemplate = new PdfTemplateResource($pdfTemplate);
        return $pdfTemplate;
    }

    public function create($pdfTemplate)
    {
        $exsist = PdfTemplate::where('status', Config::get('custom.status.active'))
                                ->where('period', $pdfTemplate['period'])
                                ->first();
        if ($exsist==null){
            $created = PdfTemplate::create($pdfTemplate);
            return new PdfTemplateResource($created);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function update($update, PdfTemplate $pdfTemplate)
    {
        $exsist = PdfTemplate::where('status', Config::get('custom.status.active'))
                            ->where('period', $update['period'])
                            ->where('id', '!=', $pdfTemplate->id)
                            ->first();
        if ($exsist==null){
            $pdfTemplate->update($update);
            return new PdfTemplateResource($pdfTemplate);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function delete(PdfTemplate $pdfTemplate)
    {
        $pdfTemplate->update(['status' => Config::get('custom.status.delete')]);
    }


}