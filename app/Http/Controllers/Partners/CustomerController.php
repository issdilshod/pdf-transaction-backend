<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Models\Partners\Customer;
use App\Services\Partners\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    private $customerService;

    public function __construct()
    {
        $this->customerService = new CustomerService();
    }
    
    /**     @OA\GET(
      *         path="/api/customer",
      *         operationId="get_customers",
      *         tags={"Partners"},
      *         summary="Get customers",
      *         description="Get customers",
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function index()
    {
        $customers = $this->customerService->get_customers();
        return $customers;
    }

    /**     @OA\POST(
      *         path="/api/customer",
      *         operationId="create_customer",
      *         tags={"Partners"},
      *         summary="Create customer",
      *         description="Create customer",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"name"},
      *                         @OA\Property(property="name", type="text")
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
            'name' => 'required'
        ]);

        $response = $this->customerService->create_customer($validated);
        return $response;
    }

    /**     @OA\GET(
      *         path="/api/customer/{id}",
      *         operationId="get_customer",
      *         tags={"Partners"},
      *         summary="Get customer",
      *         description="Get customer",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="customer id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function show(Customer $customer)
    {
        $customer = $this->customerService->get_customer($customer);
        return $customer;
    }

    /**     @OA\PUT(
      *         path="/api/customer/{id}",
      *         operationId="update_customer",
      *         tags={"Partners"},
      *         summary="Update customer",
      *         description="Update customer",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="customer id",
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
      *                         @OA\Property(property="name", type="text")
      *                     ),
      *                 ),
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => ''
        ]);

        $response = $this->customerService->update_customer($validated, $customer);
        return $response;
    }

    /**     @OA\DELETE(
      *         path="/api/customer/{id}",
      *         operationId="delete_customer",
      *         tags={"Partners"},
      *         summary="Delete customer",
      *         description="Delete customer",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="customer id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function destroy(Customer $customer)
    {
        $this->customerService->delete_customer($customer);
    }

    /**     @OA\GET(
      *         path="/api/customer/search/{search}",
      *         operationId="search_customer",
      *         tags={"Partners"},
      *         summary="Search customer",
      *         description="Search customer",
      *             @OA\Parameter(
      *                 name="search_val",
      *                 in="path",
      *                 description="customer search val",
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
        $customers = $this->customerService->search_customer($search);
        return $customers;
    }
}
