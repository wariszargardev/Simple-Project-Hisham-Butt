<?php

namespace App\Http\Middleware;

use App\Models\UserToken;
use Closure;
use Illuminate\Http\Request;

class UserAuthenticationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');
        if(!$token){
            return response()->json([
                'success'   => false,
                'message'   => 'Token not found',
                'data' => [],
                'status' => 404
            ]);
        }
        else{
            try {
                $token = decrypt($token);
            }catch (\Exception $exception){
                return response()->json([
                    'success'   => false,
                    'message'   => 'Token is invalid',
                    'data' => [],
                    'status' => 404
                ]);
            }

            $userToken = UserToken::where("token", $token)->first();
            if(!$userToken){
                return response()->json([
                    'success'   => false,
                    'message'   => 'Token is invalid',
                    'data' => [],
                    'status' => 404
                ]);
            }

            $request->merge(['user' => $userToken->user]);

            return $next($request);
        }
    }
}
