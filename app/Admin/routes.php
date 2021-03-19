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
        'auth/users'    =>  'UserController',
        'customers'     =>  'CustomerController'
    ]);
});

Route::group(['middleware' => ['web']], function (Router $router) {
    $router->post('/auth/users/updateProfile', 'App\\Admin\\Controllers\\AuthController@updateProfile')->name('admin.auth.users.updateProfile');
    $router->get('/auth/users/register', 'App\\Admin\\Controllers\\RegisterController@getRegister')->name('admin.auth.users.register');
    $router->post('/auth/users/register', 'App\\Admin\\Controllers\\RegisterController@postRegister')->name('admin.auth.users.postRegister');
    $router->get('/auth/users/forgotPassword', 'App\\Admin\\Controllers\\ForgotPasswordController@getForgotPassword')->name('admin.auth.users.getForgotPassword');
    $router->post('/auth/users/postForgotPassword', 'App\\Admin\\Controllers\\ForgotPasswordController@postForgotPassword')->name('admin.auth.users.postForgotPassword');
    $router->get('/auth/users/getVerifyForgotPassword', 'App\\Admin\\Controllers\\ForgotPasswordController@getVerifyForgotPassword')->name('admin.auth.users.getVerifyForgotPassword');
    $router->post('/auth/users/postVerifyForgotPassword', 'App\\Admin\\Controllers\\ForgotPasswordController@postVerifyForgotPassword')->name('admin.auth.users.postVerifyForgotPassword');
});

