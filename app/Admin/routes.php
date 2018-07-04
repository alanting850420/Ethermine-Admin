<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->resource('user', 'UserController');
    $router->resource('group', 'GroupController');
    $router->resource('miner', 'MinerController');
    $router->resource('worker', 'WorkerController');
});
