<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function(){
    return view('create_url');
});

$router->get('/{id_url:[A-Za-z0-9]+}',function($id_url){
    return view('view_url', ['id_url'=>$id_url]);
});

$router->get('/ver/estadisticas', function(){
    return view('statistics');
});
