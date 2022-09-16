<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

/**
 * 本の一覧表示（books.blade.php）
 */
Route::get('/', [BooksController::class, "index"]);

/**
 * 本を追加
 */
Route::post('/books', [BooksController::class, 'store']);

/**
 * 本の更新画面へ遷移
 */
Route::post('/booksedit/{books}', [BooksController::class, "toedit"]);

/**
 * 本を更新
 */
Route::post('/books/update', [BooksController::class, 'update']);

/**
 * 本を削除
 */
Route::delete("/book/{book}", [BooksController::class, "destroy"]);

Auth::routes();
Route::get("/home", [BooksController::class, "index"])->name("home");

Route::group(["middleware"=>"auth"],function(){
    //welcomeページを表示
    Route::get("/",function(){
        return view("wellcome");
    });
});
