<?php

namespace App\Services\Helpers;

use App\Http\Resources\Helpers\PdfImageResource;
use App\Models\Helpers\PdfImage;
use Illuminate\Support\Facades\Config;

class PdfImageService{


    public function all()
    {
        $pdfImage = PdfImage::orderBy('period', 'DESC')
                                    ->where('status', Config::get('custom.status.active'))
                                    ->get();
        return PdfImageResource::collection($pdfImage);
    }

    public function get(PdfImage $pdfImage)
    {
        $pdfImage = new PdfImageResource($pdfImage);
        return $pdfImage;
    }

    public function create($pdfImage)
    {
        $exsist = PdfImage::where('status', Config::get('custom.status.active'))
                                ->where('period', $pdfImage['period'])
                                ->first();
        if ($exsist==null){
            $created = PdfImage::create($pdfImage);
            return new PdfImageResource($created);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function update($update, PdfImage $pdfImage)
    {
        $exsist = PdfImage::where('status', Config::get('custom.status.active'))
                            ->where('period', $update['period'])
                            ->where('id', '!=', $pdfImage->id)
                            ->first();
        if ($exsist==null){
            $pdfImage->update($update);
            return new PdfImageResource($pdfImage);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function delete(PdfImage $pdfImage)
    {
        $pdfImage->update(['status' => Config::get('custom.status.delete')]);
    }

}