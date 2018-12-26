<?php

/*
|--------------------------------------------------------------------------
| Application Routes /api
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/urls', 'ShortUrlController@create');

$router->group(['prefix' => '/urls/{id_url:[A-Za-z0-9]+}', 'middleware' => ['url_short_id_exist', 'url_short_check_pass']], function () use ($router) {
    //View url shortened
    $router->get('/', 'ShortUrlController@show');
    //View statistics url shortened
    $router->get('/statistics/{type}',['middleware' => 'url_short_statistic_type_valid', 'uses' => 'ShortUrlStatisticsController@show']);
});