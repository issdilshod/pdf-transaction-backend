<?php

namespace App\Http\Controllers\Statements;

use App\Http\Controllers\Controller;
use App\Models\Statements\StatementPeriod;
use App\Services\Statements\StatementPeriodService;
use Illuminate\Http\Request;

class StatementPeriodController extends Controller
{
    private $statementPeriodService;

    public  function __construct()
    {
        $this->statementPeriodService = new StatementPeriodService();
    }

    /**     @OA\POST(
      *         path="/api/statement-period",
      *         operationId="create_statementPeriod",
      *         tags={"Statements"},
      *         summary="Create statement period",
      *         description="Create statement period",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"statement_id", "period"},
      *                         @OA\Property(property="statement_id", type="integer"),
      *                         @OA\Property(property="period", type="date")
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
            'statement_id' => 'required',
            'period' => 'required'
        ]);

        $response = $this->statementPeriodService->create_statementPeriod($validated);
        return $response;
    }

    /**     @OA\PUT(
      *         path="/api/statement-period/{id}",
      *         operationId="update_statementPeriod",
      *         tags={"Statements"},
      *         summary="Update statement period",
      *         description="Update statement period",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="statement period id",
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
      *                         @OA\Property(property="period", type="date")
      *                     ),
      *                 ),
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function update(Request $request, StatementPeriod $statementPeriod)
    {
        $validated = $request->validate([
            'period' => ''
        ]);

        $response = $this->statementPeriodService->update_statementPeriod($validated, $statementPeriod);
        return $response;
    }

    /**     @OA\DELETE(
      *         path="/api/statement-period/{id}",
      *         operationId="delete_statementPeriod",
      *         tags={"Statements"},
      *         summary="Delete statement period",
      *         description="Delete statement period",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="statement period id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function destroy(StatementPeriod $statementPeriod)
    {
        $this->statementPeriodService->delete_statementPeriod($statementPeriod);
    }
}