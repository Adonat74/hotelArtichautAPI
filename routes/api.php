<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\NewsArticleController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


// CONTENT ROUTES
Route::prefix('content')->controller(ContentController::class)->group(function () {
    //get ALL contents
    Route::get('/', 'getAllContent');
    //add ONE content
    Route::get('/{id}', 'getSingleContent');
    //add ONE content
    Route::post('/', 'addContent');
    //modify ONE content
    Route::put('/{id}', 'updateContent');
    //delete ONE content
    Route::delete('/{id}', 'deleteContent');
});

// NEWS ARTICLES ROUTES
Route::prefix('news')->controller(NewsArticleController::class)->group(function () {
    //get ALL news
    Route::get('/', 'getAllNewsArticle');
    //add ONE news
    Route::get('/{id}', 'getSingleNewsArticle');
    //add ONE news
    Route::post('/', 'addNewsArticle');
    //modify ONE news
    Route::put('/{id}', 'updateNewsArticle');
    //delete ONE news
    Route::delete('/{id}', 'deleteNewsArticle');
});
