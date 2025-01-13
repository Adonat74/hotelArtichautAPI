<?php

use App\Http\Controllers\ContentController;
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
