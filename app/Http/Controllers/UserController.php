<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $userService;

    /**
     * First init of controller
     * 
     * @return void
     */
    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**     @OA\GET(
      *         path="/api/user",
      *         operationId="get_users",
      *         tags={"User"},
      *         summary="Get users",
      *         description="Get users",
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function index()
    {
        $users = $this->userService->get_users();
        return $users;
    }

    /**     @OA\POST(
      *         path="/api/user",
      *         operationId="create_user",
      *         tags={"User"},
      *         summary="Create user",
      *         description="Create user",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"username", "password", "first_name"},
      *                         @OA\Property(property="username", type="text"),
      *                         @OA\Property(property="password", type="text"),
      *                         @OA\Property(property="first_name", type="text"),
      *                         @OA\Property(property="last_name", type="text")
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
            'username' => 'required',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => ''
        ]);

        $response = $this->userService->create_user($validated);
        return $response;
    }

    /**     @OA\GET(
      *         path="/api/user/{id}",
      *         operationId="get_user",
      *         tags={"User"},
      *         summary="Get user",
      *         description="Get user",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="user id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function show(User $user)
    {
        $user = $this->userService->get_user($user);
        return $user;
    }

    /**     @OA\PUT(
      *         path="/api/user/{id}",
      *         operationId="update_user",
      *         tags={"User"},
      *         summary="Update user",
      *         description="Update user",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="user id",
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
      *                         @OA\Property(property="username", type="text"),
      *                         @OA\Property(property="password", type="text"),
      *                         @OA\Property(property="first_name", type="text"),
      *                         @OA\Property(property="last_name", type="text")
      *                     ),
      *                 ),
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => '',
            'password' => '',
            'first_name' => '',
            'last_name' => ''
        ]);

        $response = $this->userService->update_user($validated, $user);
        return $response;
    }

    /**     @OA\DELETE(
      *         path="/api/user/{id}",
      *         operationId="delete_user",
      *         tags={"User"},
      *         summary="Delete user",
      *         description="Delete user",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="user id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function destroy(User $user)
    {
        $this->userService->delete_user($user);
    }
}
