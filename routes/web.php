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

Route::get('/', 'dashboard\DashboardController@default');

Auth::routes();

Route::get('/dashboard', 'dashboard\DashboardController@index')->name('dashboard');


/**
 * Following routes is secure API
 */
Route::get('/api/secure/profileDetail','api\SecureApi@getProfileDetail')->name('api.profileDetail');
Route::get('/api/secure/lastViewedProject','api\SecureApi@getLastViewedProject')->name('api.lastViewedProject');
Route::get('/api/secure/recentProjects/{start?}/{limit?}','api\SecureApi@getRecentProjects')->name('api.recentProjects');
