<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin_array = [852599845071749240, 982897026549293087];
        $discord_id = Auth::user()->discord_id;
        if(!in_array($discord_id, $admin_array)){
            return redirect()->route('selecthub')->with('error', 'You are not authorized to access this page');
        }
        return $next($request);
    }
}
