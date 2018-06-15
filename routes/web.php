<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/verify/{token}', 'Auth\RegisterController@verify')->name('register.verify');

Route::get('/cabinet', 'Cabinet\HomeController@index')->name('cabinet');

Route::group(
    [
        'prefix' => 'admin',
        'as' => 'admin.',
        'namespace' => 'Admin',
        'middleware' => ['auth', 'can:admin-panel'],
    ],
    function () {

        Route::get('/', 'HomeController@index')->name('home');

        /** admin.users */
        Route::post('/users/{user}/verify', 'UsersController@verify')->name('users.verify');
        Route::resource('users', 'UsersController');

        /** admin.regions */
        Route::resource('regions', 'RegionsController');
    });

