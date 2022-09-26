<?php

namespace App\Services\Partners;

use App\Http\Resources\Partners\SenderResource;
use App\Models\Partners\Sender;
use Illuminate\Support\Facades\Config;

class SenderService {

    public function get_senders() 
    {
        $senders = Sender::orderBy('created_at', 'DESC')
                            ->where('status', Config::get('custom.status.active'))
                            ->get();
        return SenderResource::collection($senders);
    }

    public function get_sender(Sender $sender) 
    {
        $sender = new SenderResource($sender);
        return $sender;
    }

    public function create_sender($sender)
    {
        $exsist = Sender::where('status', Config::get('custom.status.active'))
                        ->where('it_id', $sender['it_id'])
                        ->first();
        if ($exsist==null){
            $created = Sender::create($sender);
            return new SenderResource($created);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function update_sender($update, Sender $sender)
    {
        $exsist = Sender::where('status', Config::get('custom.status.active'))
                        ->where('it_id', $update['it_id'])
                        ->where('id', '!=', $sender->id)
                        ->first();
        if ($exsist==null){
            $sender->update($update);
            return new SenderResource($sender);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function delete_sender(Sender $sender)
    {
        $sender->update(['status' => Config::get('custom.status.delete')]);
    }

    public function search_sender($search)
    {
        $senders = Sender::orderBy('created_at', 'DESC')
                            ->where('status', Config::get('custom.status.active'))
                            ->where('name', 'LIKE', '%' . $search . '%')
                            ->get();
        return SenderResource::collection($senders);
    }
}