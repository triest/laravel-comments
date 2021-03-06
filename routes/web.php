<?php

use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index']);


Auth::routes();

Route::get('/home', function (){
    return view('home');
})->name('home');

Route::resource('api/comment', CommentController::class)->except('create','edit');
Route::post('api/comment/like','CommentController@like');
