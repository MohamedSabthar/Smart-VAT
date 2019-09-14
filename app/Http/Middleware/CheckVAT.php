<?php

namespace App\Http\Middleware;

use Illuminate\Support\Str;

use Closure;
use App\Vat;
use Auth;

class CheckVAT
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
        if (Auth::user()->role=='admin') {
            return $next($request);                                                 //if admin can access all vat categories
        }
        
        $authorizedRoutes = Auth::user()->userVat->pluck('vat')->pluck('route');    //get all the vat routes that are authorized for the user
        // dd($authorizedRoutes->all());

        foreach ($authorizedRoutes->all() as $route) {
            if (Str::startsWith($request->path(), $route)) {                        //allowing user if only has given accessess to vat category
                return $next($request);                                             // dd($request->path()); gives the requested path from url
            }
        }
        abort(403);
    }
}