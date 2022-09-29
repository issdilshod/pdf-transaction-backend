<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\TransactionCategory;
use App\Services\Transactions\TransactionCategoryService;
use Illuminate\Http\Request;

class TransactionCategoryController extends Controller
{
    private $transactionCategoryService;

    public  function __construct()
    {
        $this->transactionCategoryService = new TransactionCategoryService();
    }

    /**     @OA\GET(
      *         path="/api/transaction-category",
      *         operationId="get_transactionCategories",
      *         tags={"Transaction"},
      *         summary="Get transaction categories",
      *         description="Get transaction categories",
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function index()
    {
        $transactionCategories = $this->transactionCategoryService->get_transactionCategories();
        return $transactionCategories;
    }

    /**     @OA\POST(
      *         path="/api/transaction-category",
      *         operationId="create_transactionCategory",
      *         tags={"Transaction"},
      *         summary="Create transaction category",
      *         description="Create transaction category",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"transaction_type_id", "name", "offset", "customer", "sender"},
      *                         @OA\Property(property="transaction_type_id", type="integer"),
      *                         @OA\Property(property="name", type="integer"),
      *                         @OA\Property(property="offset", type="text"),
      *                         @OA\Property(property="customer", type="bool"),
      *                         @OA\Property(property="sender", type="bool"),
      *                         @OA\Property(property="descriptions[]", type="text")
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
            'transaction_type_id' => 'required',
            'name' => 'required',
            'offset' => '',
            'customer' => '',
            'sender' => '',
            'descriptions' => ''
        ]);

        $response = $this->transactionCategoryService->create_transactionCategory($validated);
        return $response;
    }

    /**     @OA\GET(
      *         path="/api/transaction-category/{id}",
      *         operationId="get_transactionCategory",
      *         tags={"Transaction"},
      *         summary="Get transaction category",
      *         description="Get transaction category",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="transaction category id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function show(TransactionCategory $transactionCategory)
    {
        $transactionCategory = $this->transactionCategoryService->get_transactionCategory($transactionCategory);
        return $transactionCategory;
    }

    /**     @OA\PUT(
      *         path="/api/transaction-category/{id}",
      *         operationId="update_transactionCategory",
      *         tags={"Transaction"},
      *         summary="Update transaction category",
      *         description="Update transaction category",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="transaction category id",
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
      *                         @OA\Property(property="transaction_category_id", type="integer"),
      *                         @OA\Property(property="name", type="text"),
      *                         @OA\Property(property="offset", type="integer"),
      *                         @OA\Property(property="customer", type="bool"),
      *                         @OA\Property(property="sender", type="bool"),
      *                         @OA\Property(property="descriptions[]", type="text")
      *                     ),
      *                 ),
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function update(Request $request, TransactionCategory $transactionCategory)
    {
        $validated = $request->validate([
            'transaction_type_id' => '',
            'name' => '',
            'offset' => '',
            'customer' => '',
            'sender' => '',
            'descriptions' => '',
            'descriptions_to_delete' => '',
        ]);

        $response = $this->transactionCategoryService->update_transactionCategory($validated, $transactionCategory);
        return $response;
    }

    /**     @OA\DELETE(
      *         path="/api/transaction-category/{id}",
      *         operationId="delete_transactionCategory",
      *         tags={"Transaction"},
      *         summary="Delete transaction category",
      *         description="Delete transaction category",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="transaction category id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function destroy(TransactionCategory $transactionCategory)
    {
        $this->transactionCategoryService->delete_transactionCategory($transactionCategory);
    }
}
