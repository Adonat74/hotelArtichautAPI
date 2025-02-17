<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NewsArticleController;
use App\Http\Controllers\ReviewController;
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
    Route::get('/lang-{lang}', 'getAllContents'); // get ALL contents
    Route::get('/{id}', 'getSingleContent'); // get ONE content
    Route::post('/', 'addContent'); // add ONE content
    Route::post('/{id}', 'updateContent'); // modify ONE content (POST is used for updates as Laravel doesn't support file uploads via PUT)
    Route::delete('/{id}', 'deleteContent'); // delete ONE content
});

// NEWS ARTICLES ROUTES
Route::prefix('news')->controller(NewsArticleController::class)->group(function () {
    Route::get('/lang-{lang}', 'getAllNewsArticles'); // get ALL news
    Route::get('/{id}', 'getSingleNewsArticle'); // get ONE news
    Route::post('/', 'addNewsArticle'); // add ONE news
    Route::post('/{id}', 'updateNewsArticle'); // modify ONE news (POST is used for updates as Laravel doesn't support file uploads via PUT)
    Route::delete('/{id}', 'deleteNewsArticle'); // delete ONE news
});

// SERVICE ROUTES
Route::prefix('service')->controller(ServiceController::class)->group(function () {
    Route::get('/lang-{lang}', 'getAllServices'); // get ALL services
    Route::get('/{id}', 'getSingleService'); // get ONE service
    Route::post('/', 'addService'); // add ONE service
    Route::post('/{id}', 'updateService'); // modify ONE service (POST is used for updates as Laravel doesn't support file uploads via PUT)
    Route::delete('/{id}', 'deleteService'); // delete ONE service
});

// REVIEW ROUTES
Route::prefix('review')->controller(ReviewController::class)->group(function () {
    Route::get('/', 'getAllReviews'); // get ALL reviews
    Route::get('/{id}', 'getSingleReview'); // get ONE review
    Route::post('/', 'addReview'); // add ONE review
    Route::post('/{id}', 'updateReview'); // modify ONE review (POST is used for updates as Laravel doesn't support file uploads via PUT)
    Route::delete('/{id}', 'deleteReview'); // delete ONE review
});

// LANGUAGE ROUTES
Route::prefix('language')->controller(LanguageController::class)->group(function () {
    Route::get('/', 'getAllLanguages'); // get ALL languages
    Route::get('/{id}', 'getSingleLanguage'); // get ONE languageController
    Route::post('/', 'addLanguage'); // add ONE languageController
    Route::post('/{id}', 'updateLanguage'); // modify ONE languageController (POST is used for updates as Laravel doesn't support file uploads via PUT)
    Route::delete('/{id}', 'deleteLanguage'); // delete ONE languageController
});

Route::prefix('rooms-category')->group(function () {
    Route::get('/lang-{lang}', [RoomsCategoryController::class, 'getAllCategories']); // Liste toutes les catégories
    Route::post('/', [RoomsCategoryController::class, 'addCategory']); // Crée une nouvelle catégorie
    Route::get('/{id}', [RoomsCategoryController::class, 'getSingleCategory']); // Affiche une catégorie spécifique
    Route::post('/{id}', [RoomsCategoryController::class, 'updateCategory']); // Met à jour une catégorie
    Route::delete('/{id}', [RoomsCategoryController::class, 'deleteCategory']); // Supprime une catégorie
});

Route::prefix('room')->group(function () {
    Route::get('/lang-{lang}', [RoomController::class, 'getAllRooms']);
    Route::post('/', [RoomController::class, 'addRoom']);
    Route::get('/{id}', [RoomController::class, 'getSingleRoom']);
    Route::post('/{id}', [RoomController::class, 'updateRoom']);
    Route::delete('/{id}', [RoomController::class, 'deleteRoom']);
});

Route::prefix('rooms-feature')->group(function () {
    Route::get('/lang-{lang}', [RoomsFeatureController::class, 'getAllFeatures']);
    Route::post('/', [RoomsFeatureController::class, 'addFeature']);
    Route::get('/{id}', [RoomsFeatureController::class, 'getSingleFeature']);
    Route::post('/{id}', [RoomsFeatureController::class, 'updateFeature']);
    Route::delete('/{id}', [RoomsFeatureController::class, 'deleteFeature']);
});

