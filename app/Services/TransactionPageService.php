<?php

namespace App\Services;

use App\Http\Resources\TransactionPageResource;
use App\Models\TransactionPage;
use Illuminate\Support\Facades\Config;

class TransactionPageService {

    public function get_transactionPages()
    {
        $transactionPages = TransactionPage::orderBy('page', 'ASC')
                                            ->where('status', Config::get('custom.status.active'))
                                            ->get();
        return TransactionPageResource::collection($transactionPages);
    }

    public function get_transactionPage(TransactionPage $transactionPage)
    {
        $transactionPage = new TransactionPageResource($transactionPage);
        return $transactionPage;
    }

    public function create_transactionPage($transactionPage)
    {
        $exsist = TransactionPage::where('status', Config::get('custom.status.active'))
                                    ->where('page', $transactionPage['page'])
                                    ->first();
        if ($exsist==null){
            $created = TransactionPage::create($transactionPage);
            return new TransactionPageResource($created);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function update_transactionPage($update, TransactionPage $transactionPage)
    {
        $exsist = TransactionPage::where('status', Config::get('custom.status.active'))
                                    ->where('page', $update['page'])
                                    ->where('id', '!=', $transactionPage->id)
                                    ->first();
        if ($exsist==null){
            $transactionPage->update($update);
            return new TransactionPageResource($transactionPage);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function delete_transactionPage(TransactionPage $transactionPage)
    {
        $transactionPage->update(['status' => Config::get('custom.status.delete')]);
    }
}