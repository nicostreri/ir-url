<?php
/**
 * Created by PhpStorm.
 * User: nico
 * Date: 23/12/18
 * Time: 04:24
 */

namespace App\Http\Middleware;
use Helpers;
use Closure;

class ShortUrlCheckPassMiddleware {
    /**
     * Run the request filter.
     * Check the password of short url, if it have.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $url = \App\Shorturl::whereId(Helpers::convertBase62SymbolToInt($request->route('id_url')))->first();
        $pass = $request->input('pass', '');

        if ($url->getPassAttribute() != null && !($url->getPassAttribute() == hash('sha256', $pass))) {
            return response()->json(['error' => 401, 'message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}