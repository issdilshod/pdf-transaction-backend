<?php

namespace App\Http\Middleware;

use App\Models\Account\UserAccessToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class AuthenticateCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        $user_access_token = UserAccessToken::where('token', $token)
                                                ->where('status', Config::get('custom.status.active'))
                                                ->where('expires_at', '>', Carbon::now()->toDateTimeString())
                                                ->first();
        if (!$user_access_token){
            return response()->json([
                'error' => 'Not Authorized',
            ], 401);
        }
        $request->merge(['user_id' => $user_access_token->user_id]);
        return $next($request);
    }
}
