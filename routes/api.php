<?php

use App\Article;
use Illuminate\Http\Request;
//UseApp\Article;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
  //  return $request->user();
//});

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');
Route::get('articles', 'ArticleController@index');





Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::get('articles/{article}/image', 'ArticleController@image');

    //ARTICLES
    Route::get('articles/{article}', 'ArticleController@show');
    Route::post('articles', 'ArticleController@store');
    Route::put('articles/{article}', 'ArticleController@update');
    Route::delete('articles/{article}', 'ArticleController@delete');

    //COMMENTS
    Route::get('articles/{article}/comments', 'CommentController@index');
    Route::get('articles/{article}/comments/{comments}', 'CommentController@show');
    Route::post('articles/{article}/comments', 'CommentController@store');
    Route::put('articles/{article}/comments/{comments}', 'CommentController@update');
    Route::delete('articles/{article}/comments/{comments}', 'CommentController@delete');

});



