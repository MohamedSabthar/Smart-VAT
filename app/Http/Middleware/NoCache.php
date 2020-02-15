<?php

namespace App\Http\Middleware;

use Closure;

class NoCache
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
        $response = $next($request);

        $response->header('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');
        $response->header('Last-Modified', gmdate("D, d M Y H:i:s"). "GMT");
        $response->header('Cache-Control', 'private, no-store, max-age=0, no-cache, must-revalidate, post-check=0, pre-check=0');
        $response->header("Pragma", "no-cache");

        return $response;
    }
}