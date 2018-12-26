<?php
/**
 * Created by PhpStorm.
 * User: nico
 * Date: 24/12/18
 * Time: 19:38
 */

namespace App\Http\Controllers;

use App\Statistic;
use Helpers;
use App\Shorturl;
use http\Url;
use Illuminate\Support\Facades\DB;

class ShortUrlStatisticsController extends Controller {


    /**
     * Show statistics of a specific short url.
     *
     * @param  string  $id_url
     * @param string $type
     * @return Response
     */
    public function show($id_url, $type){
        //It Calculate timestamp, according type of statistic
        $time = time();
        switch ($type){
            case 'hour':
                $time -= 3600;
                break;
            case 'day':
                $time -= 86400;
                break;
            case 'week':
                $time -= 604800;
                break;
            case'month':
                $time -= 2592000;
                break;
            case 'year':
                $time -= 31536000;
                break;
        }
        //It generate statistics
        $url = Shorturl::whereId(Helpers::convertBase62SymbolToInt($id_url))->first();
        $statistics = array();

        $statistics['total_accesses'] = $url->statisticsSince($time)->count();
        $statistics['countries'] = $url->statisticsSince($time)->groupBy('country')->select('country', DB::raw('count(*) as cant'))->get();
        $statistics['os'] = $url->statisticsSince($time)->groupBy('os')->select('os', DB::raw('count(*) as cant'))->get();
        $statistics['browsers'] = $url->statisticsSince($time)->groupBy('browser')->select('browser', DB::raw('count(*) as cant'))->get();
        $statistics['devices']  = $url->statisticsSince($time)->groupBy('type_device')->select(DB::raw('type_device as device'), DB::raw('count(*) as cant'))->get();
        return response()->json($statistics);
    }
}