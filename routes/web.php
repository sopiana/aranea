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
Route::get('/api/secure/projectList/{start?}/{limit?}','api\SecureApi@getProjectList')->name('api.projectList');
Route::get('/api/secure/projectListCount','api\SecureApi@getProjectListCount')->name('api.projectListCount');
Route::get('/api/secure/requestList/{start?}/{limit?}','api\SecureApi@getRequestList')->name('api.requestList');
Route::get('/api/secure/requirementList/{start?}/{limit?}','api\SecureApi@getRequirementList')->name('api.requirementList');
Route::get('/api/secure/testCaseList/{start?}/{limit?}','api\SecureApi@getTestCaseList')->name('api.testCaseList');
Route::get('/api/secure/releaseList/{start?}/{limit?}','api\SecureApi@getReleaseList')->name('api.releaseList');
Route::get('/api/secure/bugList/{start?}/{limit?}','api\SecureApi@getBugList')->name('api.bugList');
