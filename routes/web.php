<?php

use Illuminate\Support\Facades\Route;

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

//////////////////////////////
// Admin機能のルーティング定義 (Folder: Admin)
//////////////////////////////
Route::group(['namespace' => 'Admin', 'as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        //ログイン
        Route::get('login', 'LoginController@showLoginForm')->name('showLoginForm');
        Route::post('login', 'LoginController@login')->name('login');
        //ログアウト
        Route::get('logout', 'LoginController@logout')->name('logout');
        //2回認証OTP
        Route::resource('verify', 'TwoFactorController')->only(['index', 'store']);
        //再発行コードOTP
        Route::get('verify/resend', 'TwoFactorController@resend')->name('verify.resend');
    });

    //認証後
    Route::middleware(['auth:admin', 'twofactor'])->group(function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        //Log表示
        Route::group(['prefix' => 'show-log'], function () {
            Route::get('', 'ShowLogController@index')->name('log.index');
            Route::post('', 'ShowLogController@filter')->name('log.filter');
            Route::match(['get', 'post'],'search', 'ShowLogController@search')->name('log.search');
            Route::match(['get', 'post'],'delete', 'ShowLogController@delete')->name('log.delete');
        });
        //Member表示
        Route::group(['prefix' => 'member'], function () {
            Route::get('', 'MemberController@index')->name('member.index');
            Route::post('', 'MemberController@filter')->name('member.filter');
            Route::match(['get', 'post'],'search', 'MemberController@search')->name('member.search');
            Route::match(['get', 'post'],'delete', 'MemberController@delete')->name('member.delete');
            Route::match(['get', 'post'],'create', 'MemberController@create')->name('member.create');
            Route::match(['get', 'put'],'edit', 'MemberController@edit')->name('member.edit');
        });
        //Room表示
        Route::group(['prefix' => 'room'], function () {
            Route::get('', 'RoomController@index')->name('room.index');
            Route::post('', 'RoomController@filter')->name('room.filter');
            Route::match(['get', 'post'],'search', 'RoomController@search')->name('room.search');
            Route::match(['get', 'post'],'delete', 'RoomController@delete')->name('room.delete');
            Route::match(['get', 'post'],'create', 'RoomController@create')->name('room.create');
            Route::match(['get', 'put'],'edit', 'RoomController@edit')->name('room.edit');
        });
    });
});
