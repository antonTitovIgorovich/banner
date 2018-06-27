<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/login/phone', 'Auth\LoginController@phone')->name('login.phone');

Route::post('/login/phone', 'Auth\LoginController@verify');

Route::get('/verify/{token}', 'Auth\RegisterController@verify')->name('register.verify');

Route::group([
    'prefix' => 'cabinet',
    'as' => 'cabinet.',
    'namespace' => 'Cabinet',
    'middleware' => ['auth']
],
    function () {
        Route::get('/', 'HomeController@index')->name('home');

        /** cabinet.profile */
        Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
            Route::get('/', 'ProfileController@index')->name('home');
            Route::get('/edit', 'ProfileController@edit')->name('edit');
            Route::put('/update', 'ProfileController@update')->name('update');

            /** cabinet.profile.phone */
            Route::post('/phone', 'PhoneController@request');
            Route::get('/phone', 'PhoneController@form')->name('phone');
            Route::put('/phone', 'PhoneController@verify')->name('phone.verify');
            Route::post('/phone', 'PhoneController@auth')->name('phone.auth');
        });

        /** cabinet.adverts */
        Route::resource('adverts', 'Adverts\AdvertsController');
    });

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

        /** admin.adverts */
        Route::group(['prefix' => 'adverts', 'as' => 'adverts.', 'namespace' => 'Adverts'],
            function () {

                /** admin.adverts.categories */
                Route::resource('categories', 'CategoryController');
                Route::group(['prefix' => 'categories/{category}', 'as' => 'categories.'], function () {
                    Route::post('/first', 'CategoryController@first')->name('first');
                    Route::post('/up', 'CategoryController@up')->name('up');
                    Route::post('/down', 'CategoryController@down')->name('down');
                    Route::post('/last', 'CategoryController@last')->name('last');

                    /** admin.adverts.categories.attributes */
                    Route::resource('attributes', 'AttributeController')->except('index');
                });
            });
    });

