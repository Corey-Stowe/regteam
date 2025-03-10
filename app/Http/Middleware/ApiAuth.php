<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //check if the body not have authrization key
        $authkey = "157e7af5590c1b3a1173cf390401ff6d";
        if($request->header('Authorization') != $authkey){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
