<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group([
    'prefix' => 'user',
    'namespace' => 'Api\v1',
    'middleware' => 'api.intercept'//api认证拦截中间件
], function ($router) {
    $router->post('test', 'User@_login');
});

