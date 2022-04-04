<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class myAuth
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
        $keys = ['abc','def'];

        if(!$request->has('key') || !in_array($request->key,$keys) ){
            return response()->json([
                'message' => 'no data',
            ],404);
        }
        return $next($request);
    }
}
