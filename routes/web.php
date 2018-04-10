<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


Route::group(['middleware' => 'auth'], function() {

    Route::get('/', 'AppController@dashboard')->name('home');

    Route::group(['prefix' => 'equipments'], function() {
        Route::get('/', 'EquipmentsController@equipments')->name('equipments');
        Route::get('/detail/{equipment}', 'EquipmentsController@equipment')->name('equipment');
        Route::post('/export/{equipment}', 'EquipmentsController@export')->name('equipment.export');
        Route::post('/chart/{equipment}', 'EquipmentsController@chart')->name('equipment.chart');

        Route::post('/charts/{equipment}/{id}', 'EquipmentsController@charts')->name('equipment.charts');
        Route::get('/charts/{equipment}', 'EquipmentsController@chartsDesc')->name('equipment.chartsDesc');
    });

    Route::group(['prefix' => 'profile'], function() {
        Route::get('/', 'ProfileController@profile')->name('profile');
        Route::post('/edit', 'ProfileController@edit')->name('profile.edit');
    });

    Route::group(['prefix' => 'admin', 'middleware' => 'auth.administrator'], function() {

        Route::group(['prefix' => 'settings'], function() {
            Route::get('/', 'SettingsController@index')->name('settings');
            Route::post('/ip-config', 'SettingsController@setIpAddress')->name('settings.ip-address');
            Route::post('/shutdown', 'SettingsController@shutdown')->name('settings.shutdown');
            Route::get('/shutdown', function() { return redirect()->route('settings'); });
            Route::post('/reboot', 'SettingsController@reboot')->name('settings.reboot');
            Route::get('/reboot', function() { return redirect()->route('settings'); });
            Route::post('/update', 'SettingsController@update')->name('settings.update');
            Route::post('/reset', 'SettingsController@reset')->name('settings.reset');
        });


        Route::group(['prefix' => 'technician'], function() {
            Route::get('/', 'TechnicianController@index')->name('technician');
            Route::get('/applogs', 'TechnicianController@applogs')->name('technician.applogs');
            Route::get('/syslogs', 'TechnicianController@syslogs')->name('technician.syslogs');

            Route::any('/equipments', 'TechnicianController@equipments')->name('technician.equipments');

            Route::post('/ping', 'TechnicianController@ping')->name('technician.ping');
            Route::post('/readRegisters', 'TechnicianController@readRegisters')->name('technician.read-registers');
            Route::post('/identify', 'TechnicianController@identify')->name('technician.identify');

            Route::get('/ping/{equipment}', 'TechnicianController@pingEquipment')->name('technician.equipment.ping');
            Route::get('/test/{equipment}', 'TechnicianController@testEquipment')->name('technician.equipment.test');

            Route::get('/remove/{equipment}', 'TechnicianController@remove')->name('technician.equipment.remove');
            Route::post('/add/', 'TechnicianController@addEquipment')->name('technician.equipment.add');
            Route::post('/edit/{equipment}', 'TechnicianController@editEquipment')->name('technician.equipment.edit');
            Route::get('/detail/{equipment}', 'TechnicianController@detail')->name('technician.equipment.detail');

            Route::get('/view/{equipment}', 'TechnicianController@equipment')->name('technician.equipment.info');


            Route::get('/variables/{equipment}', 'TechnicianController@variables')->name('technician.equipment.variables');
            Route::post('/variable/edit/{variable}', 'TechnicianController@editVariable')->name('technician.equipment.edit-variable');
        });


        Route::group(['prefix' => 'users'], function() {
            Route::get('/', 'UsersController@index')->name('users');
            Route::get('/list', 'UsersController@users')->name('users.list');
            Route::post('/create', 'UsersController@create')->name('users.create');
            Route::post('/remove/{user}', 'UsersController@remove')->name('users.remove');
            Route::get('/administrator/{user}/change-state', 'UsersController@changeAdministratorState')->name('users.change-administrator');
        });

    });

});