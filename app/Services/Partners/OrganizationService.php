<?php

namespace App\Services\Partners;

use App\Http\Resources\Partners\OrganizationResource;
use App\Models\Partners\Organization;
use Illuminate\Support\Facades\Config;

class OrganizationService {

    public function get_organizations()
    {
        $organizations = Organization::orderBy('created_at', 'DESC')
                                    ->where('status', Config::get('custom.status.active'))
                                    ->get();
        return OrganizationResource::collection($organizations);
    }

    public function get_organization(Organization $organization)
    {
        $organization = new OrganizationResource($organization);
        return $organization;
    }

    public function create_organization($organization)
    {
        $exsist = Organization::where('status', Config::get('custom.status.active'))
                                ->where('name', $organization['name'])
                                ->first();
        if ($exsist==null){
            $created = Organization::create($organization);
            return new OrganizationResource($created);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function update_organization($update, Organization $organization)
    {
        $exsist = Organization::where('status', Config::get('custom.status.active'))
                        ->where('name', $update['name'])
                        ->where('id', '!=', $organization->id)
                        ->first();
        if ($exsist==null){
            $organization->update($update);
            return new OrganizationResource($organization);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function delete_organization(Organization $organization)
    {
        $organization->update(['status' => Config::get('custom.status.delete')]);
    }
}