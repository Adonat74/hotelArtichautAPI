<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\NewsArticleController;
use App\Http\Controllers\RoomsCategoryController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomsFeatureController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


// CONTENT ROUTES
Route::prefix('content')->controller(ContentController::class)->group(function () {
    Route::get('/', 'getAllContents'); // get ALL contents
    Route::get('/{id}', 'getSingleContent'); // get ONE content
    Route::post('/', 'addContent'); // add ONE content
    Route::post('/{id}', 'updateContent'); // modify ONE content (POST is used for updates as Laravel doesn't support file uploads via PUT)
    Route::delete('/{id}', 'deleteContent'); // delete ONE content
});

// NEWS ARTICLES ROUTES
Route::prefix('news')->controller(NewsArticleController::class)->group(function () {
    Route::get('/', 'getAllNewsArticles'); // get ALL news
    Route::get('/{id}', 'getSingleNewsArticle'); // get ONE news
    Route::post('/', 'addNewsArticle'); // add ONE news
    Route::post('/{id}', 'updateNewsArticle'); // modify ONE news (POST is used for updates as Laravel doesn't support file uploads via PUT)
    Route::delete('/{id}', 'deleteNewsArticle'); // delete ONE news
});

// SERVICE ROUTES
Route::prefix('service')->controller(ServiceController::class)->group(function () {
    Route::get('/', 'getAllServices'); // get ALL services
    Route::get('/{id}', 'getSingleService'); // get ONE service
    Route::post('/', 'addService'); // add ONE service
    Route::post('/{id}', 'updateService'); // modify ONE service (POST is used for updates as Laravel doesn't support file uploads via PUT)
    Route::delete('/{id}', 'deleteService'); // delete ONE service
});


Route::prefix('rooms-category')->group(function () {
    Route::get('/', [RoomsCategoryController::class, 'index']); // Liste toutes les catégories
    Route::post('/', [RoomsCategoryController::class, 'store']); // Crée une nouvelle catégorie
    Route::get('/{id}', [RoomsCategoryController::class, 'show']); // Affiche une catégorie spécifique
    Route::post('/{id}', [RoomsCategoryController::class, 'update']); // Met à jour une catégorie
    Route::delete('/{id}', [RoomsCategoryController::class, 'destroy']); // Supprime une catégorie
});

Route::prefix('room')->group(function () {
    Route::get('/', [RoomController::class, 'getAllRooms']);
    Route::post('/', [RoomController::class, 'addRoom']);
    Route::get('/{id}', [RoomController::class, 'getSingleRoom']);
    Route::post('/{id}', [RoomController::class, 'updateRoom']);
    Route::delete('/{id}', [RoomController::class, 'deleteRoom']);
});

Route::apiResource('rooms-feature', RoomsFeatureController::class);
Route::prefix('rooms-categories')->group(function () {
    Route::post('{id}/features', [RoomsCategoryController::class, 'attachFeature']);
    Route::delete('{id}/features/{featureId}', [RoomsCategoryController::class, 'detachFeature']);
    Route::get('{id}/features', [RoomsCategoryController::class, 'listFeatures']);
});

