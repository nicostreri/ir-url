<?php

namespace App\Http\Controllers;

use App\Statistic;
use Illuminate\Http\Request;
use Helpers;
use App\Shorturl;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class ShortUrlController extends Controller
{
    /**
     * Create a new short url
     *
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request){
        $this->validate($request, [
            'url' => 'required|url|max:100',
            'pass' => 'nullable|string|min:4|max:32'
        ]);
        $url = new Shorturl();
        $url->url   = $request->get('url');
        $url->pass  = $request->get('pass',null);
        $url->save();
        return response()->json($url, 201);
    }

    /**
     * Show a specific short url.
     *
     * @param Request $request
     * @param  string $id_url
     * @return Response
     */
    public function show(Request $request, $id_url){
        $url = Shorturl::whereId(Helpers::convertBase62SymbolToInt($id_url))->first();

        //it is created statistic the access.
        $agent = new Agent();
        $typeDevice = 'OTHER';
        if($agent->isDesktop()) $typeDevice = 'COMPUTER';
        if($agent->isPhone()) $typeDevice = 'PHONE';
        if($agent->isTablet()) $typeDevice = 'TABLET';

        $url->statistics()->create([
            'ip' => $request->ip(),
            'browser' => $agent->browser(),
            'os' => $agent->platform(),
            'type_device' => $typeDevice, //['PHONE', 'COMPUTER', 'TABLET', 'OTHER']
            'country' => Helpers::getCodeCountry()
        ]);
        return response()->json($url);
    }

    /**
     * Show statistics of a specific short url.
     *
     * @param  string  $id_url
     * @param string $type
     * @return Response
     */
    public function showStatistic($id_url, $type){
        $url = Shorturl::whereId(Helpers::convertBase62SymbolToInt($id_url))->first();
        $statistics = array();
        $statistics['total_accesses'] = $url->statistics()->count();
        $statistics['country'] = $url->statistics()->groupBy('country')->select('country', DB::raw('count(*) as cant'))->get();
        $statistics['os'] = $url->statistics()->groupBy('os')->select('os', DB::raw('count(*) as cant'))->get();
        $statistics['browsers'] = $url->statistics()->groupBy('browser')->select('browser', DB::raw('count(*) as cant'))->get();
        $statistics['devices']  = $url->statistics()->groupBy('type_device')->select(DB::raw('type_device as device'), DB::raw('count(*) as cant'))->get();
        return response()->json($statistics);
    }
}