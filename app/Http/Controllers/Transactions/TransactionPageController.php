<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\TransactionPage;
use App\Services\Transactions\TransactionPageService;
use Illuminate\Http\Request;

class TransactionPageController extends Controller
{
    private $transactionPageService;

    public  function __construct()
    {
        $this->transactionPageService = new TransactionPageService();
    }

    /**     @OA\GET(
      *         path="/api/transaction-page",
      *         operationId="get_transactionPages",
      *         tags={"Transaction"},
      *         summary="Get transaction pages",
      *         description="Get transaction pages",
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function index()
    {
        $transactionPages = $this->transactionPageService->get_transactionPages();
        return $transactionPages;
    }

    /**     @OA\POST(
      *         path="/api/transaction-page",
      *         operationId="create_transactionPage",
      *         tags={"Transaction"},
      *         summary="Create transaction page",
      *         description="Create transaction page",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"page"},
      *                         @OA\Property(property="name", type="integer"),
      *                         @OA\Property(property="start_offset", type="text"),
      *                         @OA\Property(property="end_offset", type="text"),
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
            'page' => 'required',
            'start_offset' => '',
            'end_offset' => ''
        ]);

        $response = $this->transactionPageService->create_transactionPage($validated);
        return $response;
    }

    /**     @OA\GET(
      *         path="/api/transaction-page/{id}",
      *         operationId="get_transactionPage",
      *         tags={"Transaction"},
      *         summary="Get transaction page",
      *         description="Get transaction page",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="transaction page id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function show(TransactionPage $transactionPage)
    {
        $transactionPage = $this->transactionPageService->get_transactionPage($transactionPage);
        return $transactionPage;
    }

    /**     @OA\PUT(
      *         path="/api/transaction-page/{id}",
      *         operationId="update_transactionPage",
      *         tags={"Transaction"},
      *         summary="Update transaction page",
      *         description="Update transaction page",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="transaction page id",
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
      *                         @OA\Property(property="page", type="text"),
      *                         @OA\Property(property="start_offset", type="text"),
      *                         @OA\Property(property="end_offset", type="text"),
      *                     ),
      *                 ),
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function update(Request $request, TransactionPage $transactionPage)
    {
        $validated = $request->validate([
            'page' => '',
            'start_offset' => '',
            'end_offset' => ''
        ]);

        $response = $this->transactionPageService->update_transactionPage($validated, $transactionPage);
        return $response;
    }

    /**     @OA\DELETE(
      *         path="/api/transaction-page/{id}",
      *         operationId="delete_transactionPage",
      *         tags={"Transaction"},
      *         summary="Delete transaction page",
      *         description="Delete transaction page",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="transaction page id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function destroy(TransactionPage $transactionPage)
    {
        $this->transactionPageService->delete_transactionPage($transactionPage);
    }
}
