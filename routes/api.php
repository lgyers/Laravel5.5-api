<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::namespace('Api')->group(function ($api) {
    // 用户注册
    $api->post('users', 'UsersController@store')->name('api.users.store');
    //登录
    $api->post('authorizations', 'AuthorizationsController@store')->name('api.authorizations.store');
    // 刷新token
    $api->put('authorizations/current', 'AuthorizationsController@update')->name('api.authorizations.update');
    // 删除token
    $api->delete('authorizations/current', 'AuthorizationsController@destroy')->name('api.authorizations.destroy');
    
    // 需要 token 验证的接口
    $api->group(['middleware' => 'api.jwt.auth'], function($api) {
        // 当前登录用户信息
        $api->get('user', 'UsersController@me')->name('api.user.show');
        // 编辑登录用户信息
        $api->post('user', 'UsersController@update')->name('api.user.update');
    });

});
