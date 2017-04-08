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

$endpointService = new \Api\Services\EndpointService($app);

//$app->get('/', function () use ($app) {
//    return $app->version();
//});
//
//$app->get('user', ['middleware' => 'auth', 'action' => function () {
//    return \Illuminate\Support\Facades\Auth::user();
//}]);
//
//$app->group([
//    'prefix' => 'image',
//    'as' => 'image'
//], function () use ($app) {
//    $app->get('list', ['as' => 'list', 'uses' => 'ImageController@list']);
//    $app->get('show/{slug}', ['as' => 'show', 'uses' => 'ImageController@show']);
//    $app->get('{id}', ['as' => 'info', 'uses' => 'ImageController@info']);
//
//    $app->group(['middleware' => 'auth'], function () use ($app) {
//        $app->post('create', ['as' => 'create', 'uses' => 'ImageController@create']);
//        $app->delete('{id}', ['as' => 'delete', 'uses' => 'ImageController@delete']);
//    });
//});
//
//$app->group([
//    'prefix' => 'music',
//    'as' => 'music'
//], function () use ($app) {
//    $app->get('current', ['as' => 'current', 'uses' => 'MusicController@current']);
//});
