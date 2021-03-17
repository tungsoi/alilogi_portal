<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->resources([
        'auth/users'    =>   'UserController'
    ]);
});

Route::group(['middleware' => ['web']], function () {
    Route::get('auth/users/register', 'App\\Admin\\Controllers\\RegisterController@getRegister')->name('admin.auth.users.register');
    Route::post('auth/users/register', 'App\\Admin\\Controllers\\RegisterController@postRegister')->name('admin.auth.users.postRegister');
});

