<?php

namespace App\Http\Middleware;

use Closure;
use Helpers;

class ShortUrlMiddleware
{
    /**
     * Run the request filter.
     * Check if urlshort exist.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $url = \App\Shorturl::whereId(Helpers::convertBase62SymbolToInt($request->route('id_url')))->first();
        if($url == null){
            return response()->json(['error'=> 404, 'message'=> 'Not found' ], 404);
        }
        return $next($request);
    }

}