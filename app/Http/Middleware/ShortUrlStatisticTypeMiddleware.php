<?php
/**
 * Created by PhpStorm.
 * User: nico
 * Date: 23/12/18
 * Time: 04:11
 */

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Validator;
use Closure;

class ShortUrlStatisticTypeMiddleware{
    /**
     * Run the request filter.
     * Check if statistics type is valid
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $type = $request->route('type');
        $validator = Validator::make(['type' => $type], [
            'type' => 'in:hour,day,week,month,year'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }
        return $next($request);
    }
}