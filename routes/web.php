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

use App\Http\Controllers\Api\workOrderApiController;
use App\Http\Controllers\AutenticationController;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix'=> 'api-v1'], function() use ($router) {
    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->post('sign-in', ['uses' => AutenticationController::Authenticate, 'middleware' => 'thorttle:1,10']);
    });
    $router->get('show-workorder', ['uses' => workOrderApiController::index]);
    $router->get('get-workorder/{woid}', ['uses' => workOrderApiController::show]);
});
