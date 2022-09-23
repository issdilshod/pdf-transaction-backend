<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
use App\Services\UserAccessTokenService;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    private $accountService;
    private $userAccessTokenService;

    /**
     * Inin of controller
     * 
     * @return void
     */
    public function __construct()
    {
        $this->accountService = new AccountService();
        $this->userAccessTokenService = new UserAccessTokenService();
    }
    
    /**     @OA\POST(
      *         path="/api/login",
      *         operationId="login",
      *         tags={"Account"},
      *         summary="Login",
      *         description="Login",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"username", "password"},
      *                         @OA\Property(property="username", type="text"),
      *                         @OA\Property(property="password", type="text"),
      *                         @OA\Property(property="first_name", type="text")
      *                     ),
      *                 ),
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=404, description="Resource Not Found")
      *     )
      */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $respond = $this->accountService->login($validated);
        if (!$respond){
            return response()->json([
                'error' => 'Invalid username or password.'
            ], 404);
        }else{
            $respond = $this->userAccessTokenService->create_access_token($request, $validated);
        }
        return $respond;
    }

    /**     @OA\POST(
      *         path="/api/logout",
      *         operationId="logout",
      *         tags={"Account"},
      *         summary="Logout",
      *         description="Logout",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"token"},
      *                         @OA\Property(property="token", type="text")
      *                     ),
      *                 ),
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found")
      *     )
      */
    public function logout(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required'
        ]);
        
        $this->userAccessTokenService->delete_user_access_token($validated);
    }

    /**     @OA\GET(
      *         path="/api/is_auth",
      *         operationId="is_auth",
      *         tags={"Account"},
      *         summary="Is Auth",
      *         description="Is Auth",
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found")
      *     )
      */
    public function is_auth()
    {
        // NOTE: Checking on middleware
        return response()->json([
            'msg' => 'Authorized.'
        ], 200);
    }
}
