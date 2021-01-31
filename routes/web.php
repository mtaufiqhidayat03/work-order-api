<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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


$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', function() {
    return \Illuminate\Support\Str::random(32);
});

$router->group(['prefix'=> 'api-v1'], function() use ($router) {
    $router->post('sign-in', ['uses' => 'AutenticationController@AuthenticateToken',
        'middleware' => 'thorttle:10,1']);
    $router->get('show-workorder', ['uses' => 'WorkOrderApiController@index',
        'middleware' => 'thorttle:300,1']);
    $router->get('get-workorder/{woid}', ['uses' => 'WorkOrderApiController@show',
        'middleware' => 'thorttle:500,1']);
    $router->post('save-workorder', ['uses' => 'WorkOrderApiController@store',
        'middleware' => 'thorttle:100,1']);
    $router->post('update-workorder/{woid}', ['uses' => 'WorkOrderApiController@update',
        'middleware' => 'thorttle:50,1']);
    $router->get('delete-workorder/{woid}', ['uses' => 'WorkOrderApiController@destroy',
        'middleware' => 'thorttle:100,1']);
    $router->get('show-firebase-wo', ['uses' => 'FirebaseRealtimeController@index',
        'middleware' => 'thorttle:300,1']);
    $router->get('get-firebase-wo/{uniqueid}', ['uses' => 'FirebaseRealtimeController@show',
        'middleware' => 'thorttle:500,1']);
    $router->post('save-firebase-wo', ['uses' => 'FirebaseRealtimeController@store',
        'middleware' => 'thorttle:100,1']);
    $router->post('update-firebase-wo/{uniqueid}', ['uses' => 'FirebaseRealtimeController@update',
        'middleware' => 'thorttle:50,1']);
    $router->get('delete-firebase-wo/{uniqueid}', ['uses' => 'FirebaseRealtimeController@destroy',
        'middleware' => 'thorttle:100,1']);
});
