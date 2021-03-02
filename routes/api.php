<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Пользователи

//Создать пользователя (name)
Route::post('/user/send', 'UserController@send');
//Получить статьи пользователя (user_id, page )
Route::get('/user/getpost', 'UserController@getpost');
//Получить пользователя (user_id)
Route::get('/user/get', 'UserController@get');

//Статьи

//Отправить статью (user_id, title, text)
Route::post('/post/send', 'PostController@store');
//Получить список статей (page)
Route::get('/post', 'PostController@index');
//Получить список статей пользователей, на которые подписан пользователь ( user_id, page )
Route::get('/post/subscribe', 'PostController@subscribe');

//Подписка

//Подписаться на статьи пользователя (subscribe_id - на кого подписываются, user_id - подписант)
Route::post('/subscribe', 'SubscribeController@subscribe');
//Отписаться на статьи пользователя (subscribe_id, user_id) в случае успеха возвращает 1, если не нашел запись возвращает 0
Route::post('/unsubscribe', 'SubscribeController@unsubscribe');

//Cron Удаление статей старше 2х дней

Route::get('/post/delete', 'PostController@delete');

//Список изменений - лог (page)

Route::get('/user/action', 'UserController@action');
