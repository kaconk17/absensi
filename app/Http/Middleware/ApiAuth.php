<?php

namespace App\Http\Middleware;
use App\User;
use Closure;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request['c_token'];
        $user = User::where('api_token',base64_decode($token))->first();
        if($user){
            return $next($request);
          }
          return response()->json([
            'message' => 'Not a valid API request.',
            'code'=>'token',
            'success'=>false,
          ]);
       
    }
}
