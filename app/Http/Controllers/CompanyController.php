<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    private $companyService;

    public function __construct()
    {
        $this->companyService = new CompanyService();
    }
    
    /**     @OA\GET(
      *         path="/api/company",
      *         operationId="get_companaies",
      *         tags={"Company"},
      *         summary="Get companies",
      *         description="Get companies",
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function index()
    {
        $companies = $this->companyService->get_companies();
        return $companies;
    }

    /**     @OA\POST(
      *         path="/api/company",
      *         operationId="create_company",
      *         tags={"Company"},
      *         summary="Create company",
      *         description="Create company",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"name", "address[address_line1]", "address[address_line2]", "address[state_id]", "address[city]", "address[postal]"},
      *                         @OA\Property(property="name", type="text"),
      *                         @OA\Property(property="address[address_line1]", type="text"),
      *                         @OA\Property(property="address[address_line2]", type="text"),
      *                         @OA\Property(property="address[state_id]", type="text"),
      *                         @OA\Property(property="address[city]", type="text"),
      *                         @OA\Property(property="address[postal]", type="text"),
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
            'name' => 'required',
            'address.address_line1' => 'required',
            'address.address_line2' => 'required',
            'address.state_id' => 'required',
            'address.city' => 'required',
            'address.postal' => 'required',
        ]);

        $response = $this->companyService->create_company($validated);
        return $response;
    }

    /**     @OA\GET(
      *         path="/api/company/{id}",
      *         operationId="get_company",
      *         tags={"Company"},
      *         summary="Get company",
      *         description="Get company",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="company id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function show(Company $company)
    {
        $company = $this->companyService->get_company($company);
        return $company;
    }

    /**     @OA\PUT(
      *         path="/api/company/{id}",
      *         operationId="update_company",
      *         tags={"Company"},
      *         summary="Update company",
      *         description="Update company",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="company id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"name", "address[address_line1]", "address[address_line2]", "address[state_id]", "address[city]", "address[postal]"},
      *                         @OA\Property(property="name", type="text"),
      *                         @OA\Property(property="address[address_line1]", type="text"),
      *                         @OA\Property(property="address[address_line2]", type="text"),
      *                         @OA\Property(property="address[state_id]", type="text"),
      *                         @OA\Property(property="address[city]", type="text"),
      *                         @OA\Property(property="address[postal]", type="text"),
      *                     ),
      *                 ),
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required',
            'address.address_line1' => 'required',
            'address.address_line2' => 'required',
            'address.state_id' => 'required',
            'address.city' => 'required',
            'address.postal' => 'required',
        ]);

        $response = $this->companyService->update_company($validated, $company);
        return $response;
    }

    /**     @OA\DELETE(
      *         path="/api/company/{id}",
      *         operationId="delete_company",
      *         tags={"Company"},
      *         summary="Delete company",
      *         description="Delete company",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="company id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function destroy(Company $company)
    {
        $this->companyService->delete_company($company);
    }

    /**     @OA\GET(
      *         path="/api/company/search/{search}",
      *         operationId="search_company",
      *         tags={"Company"},
      *         summary="Search company",
      *         description="Search company",
      *             @OA\Parameter(
      *                 name="search_val",
      *                 in="path",
      *                 description="company search val",
      *                 @OA\Schema(type="text"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function search($search)
    {
        $companies = $this->companyService->search_comapny($search);
        return $companies;
    }

}
