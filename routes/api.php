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
    //get ALL contents
    Route::get('/', 'getAllContent');
    //add ONE content
    Route::get('/{id}', 'getSingleContent');
    //add ONE content
    Route::post('/', 'addContent');
    //modify ONE content
    Route::post('/{id}', 'updateContent');
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
    Route::post('/{id}', 'updateNewsArticle');
    //delete ONE news
    Route::delete('/{id}', 'deleteNewsArticle');
});

// SERVICE ROUTES
Route::prefix('service')->controller(ServiceController::class)->group(function () {
    //get ALL service
    Route::get('/', 'getAllService');
    //add ONE service
    Route::get('/{id}', 'getSingleService');
    //add ONE service
    Route::post('/', 'addService');
    //modify ONE service POST pour les update car laravel ne prend pas en compte l'upload de fichier via PUT
    Route::post('/{id}', 'updateService');
    //delete ONE service
    Route::delete('/{id}', 'deleteService');
});


    Route::prefix('rooms-categories')->group(function () {
        Route::get('/', [RoomsCategoryController::class, 'index']); // Liste toutes les catégories
        Route::post('/', [RoomsCategoryController::class, 'store']); // Crée une nouvelle catégorie
        Route::get('/{id}', [RoomsCategoryController::class, 'show']); // Affiche une catégorie spécifique
        Route::put('/{id}', [RoomsCategoryController::class, 'update']); // Met à jour une catégorie
        Route::delete('/{id}', [RoomsCategoryController::class, 'destroy']); // Supprime une catégorie
    });

    Route::prefix('rooms')->group(function () {
        Route::get('/', [RoomController::class, 'index']);
        Route::post('/', [RoomController::class, 'store']);
        Route::get('/{id}', [RoomController::class, 'show']);
        Route::put('/{id}', [RoomController::class, 'update']);
        Route::delete('/{id}', [RoomController::class, 'destroy']);
    });

    Route::apiResource('rooms-features', RoomsFeatureController::class);
    Route::prefix('rooms-categories')->group(function () {
        Route::post('{id}/features', [RoomsCategoryController::class, 'attachFeature']);
        Route::delete('{id}/features/{featureId}', [RoomsCategoryController::class, 'detachFeature']);
        Route::get('{id}/features', [RoomsCategoryController::class, 'listFeatures']);
    });

