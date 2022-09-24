<?php

namespace App\Services;

use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Support\Facades\Config;

/**
 * Address service class
 * 
 * @version Dev: @1.0.0@
 */
class AddressService {

    /**
     * Create address and returns
     * 
     * @param   Array
     * @return  Address
     */
    public function create_address($address)
    {
        $exsist = Address::where('status', Config::get('custom.status.active'))
                        ->where('type', $address['type'])
                        ->where('address_line1', $address['address_line1'])
                        ->where('address_line2', $address['address_line2'])
                        ->where('state_id', $address['state_id'])
                        ->where('city', $address['city'])
                        ->where('postal', $address['postal'])
                        ->first();
        if ($exsist==null){
            $created = Address::create($address);
            return new AddressResource($created);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    /**
     * Update address and returns
     * 
     * @param   Array
     * @param   int
     * @return  Address
     */
    public function update_address($update, $related_id)
    {
        $exsist = Address::where('status', Config::get('custom.status.active'))
                        ->where('type', $update['type'])
                        ->where('address_line1', $update['address_line1'])
                        ->where('address_line2', $update['address_line2'])
                        ->where('state_id', $update['state_id'])
                        ->where('city', $update['city'])
                        ->where('postal', $update['postal'])
                        ->where('related_id', '!=', $related_id)
                        ->first();
        if ($exsist==null){
            $address = Address::where('status', Config::get('custom.status.active'))
                                ->where('related_id', $related_id);
            $address->update($update);
            return new AddressResource($address);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    /**
     * Delete address by related_id
     * 
     * @param   int
     * @return  void
     */
    public function delete_address($related_id)
    {
        $address = Address::where('status', Config::get('custom.status.active'))
                                ->where('related_id', $related_id);
        $address->update(['status' => Config::get('custom.status.delete')]);
    }
}