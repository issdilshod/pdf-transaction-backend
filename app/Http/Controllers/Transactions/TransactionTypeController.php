<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\TransactionType;
use App\Services\Transactions\TransactionTypeService;
use Illuminate\Http\Request;

class TransactionTypeController extends Controller
{
    private $transactionTypeService;

    public  function __construct()
    {
        $this->transactionTypeService = new TransactionTypeService();
    }

    /**     @OA\GET(
      *         path="/api/transaction-type",
      *         operationId="get_transactionTypes",
      *         tags={"Transaction"},
      *         summary="Get transaction types",
      *         description="Get transaction types",
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function index()
    {
        $transactionTypes = $this->transactionTypeService->get_transactionTypes();
        return $transactionTypes;
    }

    /**     @OA\POST(
      *         path="/api/transaction-type",
      *         operationId="create_transactionType",
      *         tags={"Transaction"},
      *         summary="Create transaction type",
      *         description="Create transaction type",
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

        $response = $this->transactionTypeService->create_transactionType($validated);
        return $response;
    }

    /**     @OA\GET(
      *         path="/api/transaction-type/{id}",
      *         operationId="get_transactionType",
      *         tags={"Transaction"},
      *         summary="Get transaction type",
      *         description="Get transaction type",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="transaction type id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function show(TransactionType $transactionType)
    {
        $transactionType = $this->transactionTypeService->get_transactionType($transactionType);
        return $transactionType;
    }

    /**     @OA\PUT(
      *         path="/api/transaction-type/{id}",
      *         operationId="update_transactionType",
      *         tags={"Transaction"},
      *         summary="Update transaction type",
      *         description="Update transaction type",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="transaction type id",
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
    public function update(Request $request, TransactionType $transactionType)
    {
        $validated = $request->validate([
            'name' => ''
        ]);

        $response = $this->transactionTypeService->update_transactionType($validated, $transactionType);
        return $response;
    }

    /**     @OA\DELETE(
      *         path="/api/transaction-type/{id}",
      *         operationId="delete_transactionType",
      *         tags={"Transaction"},
      *         summary="Delete transaction type",
      *         description="Delete transaction type",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="transaction type id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function destroy(TransactionType $transactionType)
    {
        $this->transactionTypeService->delete_transactionType($transactionType);
    }
}
