<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Models\Partners\Sender;
use App\Services\Partners\SenderService;
use Illuminate\Http\Request;

class SenderController extends Controller
{

    private $senderService;

    public function __construct()
    {
        $this->senderService = new SenderService();
    }

    /**     @OA\GET(
      *         path="/api/sender",
      *         operationId="get_senders",
      *         tags={"Partners"},
      *         summary="Get senders",
      *         description="Get senders",
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function index()
    {
        $senders = $this->senderService->get_senders();
        return $senders;
    }

    /**     @OA\POST(
      *         path="/api/sender",
      *         operationId="create_sender",
      *         tags={"Partners"},
      *         summary="Create sender",
      *         description="Create sender",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"name", "it_id"},
      *                         @OA\Property(property="name", type="text"),
      *                         @OA\Property(property="it_id", type="text")
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
            'it_id' => 'required'
        ]);

        $response = $this->senderService->create_sender($validated);
        return $response;
    }

    /**     @OA\GET(
      *         path="/api/sender/{id}",
      *         operationId="get_sender",
      *         tags={"Partners"},
      *         summary="Get sender",
      *         description="Get sender",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="sender id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function show(Sender $sender)
    {
        $sender = $this->senderService->get_sender($sender);
        return $sender;
    }

    /**     @OA\PUT(
      *         path="/api/sender/{id}",
      *         operationId="update_sender",
      *         tags={"Partners"},
      *         summary="Update sender",
      *         description="Update sender",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="sender id",
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
      *                         @OA\Property(property="name", type="text"),
      *                         @OA\Property(property="it_id", type="text")
      *                     ),
      *                 ),
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function update(Request $request, Sender $sender)
    {
        $validated = $request->validate([
            'name' => '',
            'it_id' => ''
        ]);

        $response = $this->senderService->update_sender($validated, $sender);
        return $response;
    }

    /**     @OA\DELETE(
      *         path="/api/sender/{id}",
      *         operationId="delete_sender",
      *         tags={"Partners"},
      *         summary="Delete sender",
      *         description="Delete sender",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="sender id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function destroy(Sender $sender)
    {
        $this->senderService->delete_sender($sender);
    }

    /**     @OA\GET(
      *         path="/api/sender/search/{search}",
      *         operationId="search_sender",
      *         tags={"Partners"},
      *         summary="Search sender",
      *         description="Search sender",
      *             @OA\Parameter(
      *                 name="search_val",
      *                 in="path",
      *                 description="sender search val",
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
        $senders = $this->senderService->search_sender($search);
        return $senders;
    }
}
