<?php

namespace App\Http\Controllers\Statements;

use App\Http\Controllers\Controller;
use App\Models\Statements\Statement;
use App\Services\Statements\StatementService;
use Illuminate\Http\Request;

class StatementController extends Controller
{
    private $statementService;

    public  function __construct()
    {
        $this->statementService = new StatementService();
    }

    /**     @OA\GET(
      *         path="/api/statement",
      *         operationId="get_statements",
      *         tags={"Statements"},
      *         summary="Get statements",
      *         description="Get statements",
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function index()
    {
        $statements = $this->statementService->get_statements();
        return $statements;
    }

    /**     @OA\POST(
      *         path="/api/statement",
      *         operationId="create_statement",
      *         tags={"Statements"},
      *         summary="Create statement",
      *         description="Create statement",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"company_id", "organization_id", "name"},
      *                         @OA\Property(property="company_id", type="integer"),
      *                         @OA\Property(property="organization_id", type="integer"),
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
            'company_id' => 'required',
            'organization_id' => 'required',
            'name' => ''
        ]);

        $response = $this->statementService->create_statement($validated);
        return $response;
    }

    /**     @OA\GET(
      *         path="/api/statement/{id}",
      *         operationId="get_statement",
      *         tags={"Statements"},
      *         summary="Get statement",
      *         description="Get statement",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="statement id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function show(Statement $statement)
    {
        $statement = $this->statementService->get_statement($statement);
        return $statement;
    }

    /**     @OA\PUT(
      *         path="/api/statement/{id}",
      *         operationId="update_statement",
      *         tags={"Statements"},
      *         summary="Update statement",
      *         description="Update statement",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="statement id",
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
      *                         @OA\Property(property="company_id", type="integer"),
      *                         @OA\Property(property="organization_id", type="integer"),
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
    public function update(Request $request, Statement $statement)
    {
        $validated = $request->validate([
            'company_id' => '',
            'organization_id' => '',
            'name' => ''
        ]);

        $response = $this->statementService->update_statement($validated, $statement);
        return $response;
    }

    /**     @OA\DELETE(
      *         path="/api/statement/{id}",
      *         operationId="delete_statement",
      *         tags={"Statements"},
      *         summary="Delete statement",
      *         description="Delete statement",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="statement id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function destroy(Statement $statement)
    {
        $this->statementService->delete_statement($statement);
    }
}