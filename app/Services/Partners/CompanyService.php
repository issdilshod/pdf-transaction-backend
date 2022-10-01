<?php

namespace App\Services\Partners;

use App\Http\Resources\Partners\CompanyResource;
use App\Models\Partners\Company;
use Illuminate\Support\Facades\Config;

class CompanyService {

    private $addressService;

    public function __construct()
    {
        $this->addressService = new AddressService();
    }

    public function get_companies()
    {
        $companies = Company::orderBy('created_at', 'DESC')
                                ->where('status', Config::get('custom.status.active'))
                                ->get();
        return CompanyResource::collection($companies);
    }

    public function get_company(Company $company)
    {
        $company = new CompanyResource($company);
        return $company;
    }

    public function create_company($company)
    {
        $created = Company::create($company);

        $company['address']['related_id'] = $created->id;
        $company['address']['type'] = Config::get('custom.address.type.company');

        $this->addressService->create_address($company['address']);

        return new CompanyResource($created);
    }

    public function update_company($update, Company $company)
    {
        $company->update($update);
        $this->addressService->update_address($update['address'], $company->id);

        return new CompanyResource($company);
    }

    public function delete_company(Company $company)
    {
        $company->update(['status' => Config::get('custom.status.delete')]);
    }

    public function search_comapny($search)
    {
        $companies = Company::orderBy('created_at', 'DESC')
                                ->where('status', Config::get('custom.status.active'))
                                ->where('name', 'LIKE', '%' . $search . '%')
                                ->get();
        return CompanyResource::collection($companies);
    }

    public function get_count()
    {
        $companies = Company::where('status', Config::get('custom.status.active'))
                                ->get();
        return count($companies);
    }
}