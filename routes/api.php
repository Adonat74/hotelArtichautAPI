<?php
    use App\Http\Controllers\Api\RoomsCategoryController;
    use App\Http\Controllers\Api\RoomsController;
	use App\Http\Controllers\Api\RoomsFeatureController;
	use Illuminate\Support\Facades\Route;

    Route::prefix('rooms-categories')->group(function () {
        Route::get('/', [RoomsCategoryController::class, 'index']); // Liste toutes les catégories
        Route::post('/', [RoomsCategoryController::class, 'store']); // Crée une nouvelle catégorie
        Route::get('/{id}', [RoomsCategoryController::class, 'show']); // Affiche une catégorie spécifique
        Route::put('/{id}', [RoomsCategoryController::class, 'update']); // Met à jour une catégorie
        Route::delete('/{id}', [RoomsCategoryController::class, 'destroy']); // Supprime une catégorie
    });

    Route::prefix('rooms')->group(function () {
        Route::get('/', [RoomsController::class, 'index']);
        Route::post('/', [RoomsController::class, 'store']);
        Route::get('/{id}', [RoomsController::class, 'show']);
        Route::put('/{id}', [RoomsController::class, 'update']);
        Route::delete('/{id}', [RoomsController::class, 'destroy']);
    });

		Route::apiResource('rooms-features', RoomsFeatureController::class);

				Route::prefix('rooms-categories')->group(function () {
				Route::post('{id}/features', [RoomsCategoryController::class, 'attachFeature']);
				Route::delete('{id}/features/{featureId}', [RoomsCategoryController::class, 'detachFeature']);
				Route::get('{id}/features', [RoomsCategoryController::class, 'listFeatures']);
			});
