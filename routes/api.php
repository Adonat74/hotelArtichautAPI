<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');



// CONTENT ROUTES
//get ALL contents
Route::get('/content', function () {
    return 'News';
});

//get ONE content
Route::get('/content/{id}', function (string $id) {
    return 'News number ' . $id;
});

//add ONE content
Route::post('/content', function (Request $request) {
    return 'added ' . $request;
});

//modify ONE content
Route::patch('/content/{id}', function (Request $request, string $id) {
    return 'modified ' . $request;
});

//delete ONE content
Route::delete('/content/{id}', function (Request $request, string $id) {
    return 'deleted ' . $request;
});
