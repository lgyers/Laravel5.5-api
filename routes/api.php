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
    
    // 游客可以访问的接口
    $api->get('categories', 'CategoriesController@index')->name('api.categories.index');
    //话题列表页
    $api->get('topics', 'TopicsController@index')->name('api.topics.index');
    //话题详情页
    $api->get('topics/{topic}', 'TopicsController@show')->name('api.topics.show');
    
    // 需要 token 验证的接口
    $api->group(['middleware' => 'api.jwt.auth'], function($api) {
        // 当前登录用户信息
        $api->get('user', 'UsersController@me')->name('api.user.show');
        // 编辑登录用户信息
        $api->post('user', 'UsersController@update')->name('api.user.update');
        // 当前登录用户权限
        $api->get('user/permissions', 'PermissionsController@index')->name('api.user.permissions.index');
        // 发布话题
        $api->post('topics', 'TopicsController@store')->name('api.topics.store');
        // 修改话题
        $api->patch('topics/{topic}', 'TopicsController@update')->name('api.topics.update');
        // 删除
        $api->delete('topics/{topic}', 'TopicsController@destroy')->name('api.topics.delete');


    });

});
