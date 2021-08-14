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

use App\Book;
use Illuminate\Http\Request;

// ダッシュボード
Route::get('/', 'BooksController@index');

// 登録処理
Route::post('/books', 'BooksController@store');

// 更新画面
Route::post('/booksedit/{books}', 'BooksController@edit');

//更新処理
Route::post('/books/update', 'BooksController@update');

/**
* 本を削除 
* HTMLからはGETとPOSTのみ許可されており、DELETEはない。
* Laravelの機能で@method('DELETE')を定義すると擬似的にDELETEリクエストと見せかけることができ、web.phpとしてもdeleteで受け取れる
* HTMLに展開されるコードは、<input xxx name=_method" value="DELETE">
*/
Route::post('/book/{book}', 'BooksController@delete');

// Auth
Auth::routes();
Route::get('/home', 'BooksController@index')->name('home');

