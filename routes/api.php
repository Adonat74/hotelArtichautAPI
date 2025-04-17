<?php

use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingManagementController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NewsArticleController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomsCategoryController;
use App\Http\Controllers\RoomsFeatureController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckTokenVersion;
use App\Http\Middleware\Sanitization;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>[
    'throttle:60,1',
    Sanitization::class
]], function() {
    ///////////////////////// BOOKINGS ///////////////////////
    // BOOKING ROUTES
    Route::prefix('admin/booking')->controller(AdminBookingController::class)->group(function () {
        Route::get('/', 'getAllBookings')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':employee', ]);
        Route::get('/user-{id}', 'getAllUserBookings')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':employee', ]);
        Route::get('/{id}', 'getSingleBooking')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':employee', ]);
        Route::post('/', 'addBooking')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager', ]);
        Route::post('/{id}', 'updateBooking')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager', ]);
        Route::delete('/{id}', 'deleteBooking')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager', ]);
    });

    // BOOKING ROUTES
    Route::prefix('booking')->controller(BookingController::class)->group(function () {
        Route::get('/user', 'getAllUserBookings')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::get('/{id}', 'getSingleUserBooking')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::post('/', 'addBooking')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::post('/{id}', 'updateBooking')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::delete('/{id}', 'deleteBooking')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
    });

    // BOOKING MANAGEMENT ROUTES
    Route::prefix('booking-management')->controller(BookingManagementController::class)->group(function () {
        Route::post('/stripe-webhook',  'handleWebhook');
        Route::post('/add-payment', 'addPayment')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':employee', ]);
        Route::post('/checkout', 'checkout')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class.':user']);
        Route::post('/add-services/booking-{id}', 'addServicesToBooking')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::get('/qr-code', 'sendQrCode')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::post('/total-price', 'getTotalPrice');
    });


    ////////////////////////// AUTHENTICATION //////////////////////////
    // AUTH ROUTES
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register', ]);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
    Route::get('/refresh', [AuthController::class, 'refresh'])->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);

    // USER ROUTES
    Route::prefix('user')->controller(UserController::class)->group(function () {
        Route::get('/', 'getSingleUser')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::post('/', 'updateUser')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::delete('/', 'deleteUser')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
    });

    // ADMIN USER ROUTES
    Route::prefix('admin/user')->controller(AdminUserController::class)->group(function () {
        Route::get('/', 'getAllUsers')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':employee']);
        Route::get('/{id}', 'getSingleUser')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':employee']);
        Route::post('/', 'addUser')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']);
        Route::post('/{id}', 'updateUser')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']);
        Route::delete('/{id}', 'deleteUser')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']);
    });

    // ROLE ROUTES
    Route::prefix('role')->controller(RoleController::class)->group(function () {
        Route::get('/', 'getAllRoles')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':master']);
        Route::get('/{id}', 'getSingleRole')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':master']);
        Route::post('/', 'addRole')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':master']);
        Route::post('/{id}', 'updateRole')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':master']);
        Route::delete('/{id}', 'deleteRole')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':master']);
    });


    ///////////// CMS /////////////////////
    // CONTENT ROUTES
    Route::prefix('content')->controller(ContentController::class)->group(function () {
        Route::get('/lang-{lang}', 'getAllContentsByLang'); // get ALL contents by language
        Route::get('/', 'getAllContents'); // get ALL contents
        Route::get('/{id}', 'getSingleContent'); // get ONE Content
        Route::post('/', 'addContent')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']); // add ONE Content
        Route::post('/{id}', 'updateContent')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']); // modify ONE Content (POST is used for updates as Laravel doesn't support file uploads via PUT)
        Route::delete('/{id}', 'deleteContent')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']); // delete ONE Content
    });

    // NEWS ARTICLES ROUTES
    Route::prefix('news')->controller(NewsArticleController::class)->group(function () {
        Route::get('/lang-{lang}', 'getAllNewsArticlesByLang'); // get ALL news by language
        Route::get('/', 'getAllNewsArticles'); // get ALL news
        Route::get('/{id}', 'getSingleNewsArticle'); // get ONE news
        Route::post('/', 'addNewsArticle')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']); // add ONE news
        Route::post('/{id}', 'updateNewsArticle')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']); // modify ONE news (POST is used for updates as Laravel doesn't support file uploads via PUT)
        Route::delete('/{id}', 'deleteNewsArticle')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']); // delete ONE news
    });

    // SERVICE ROUTES
    Route::prefix('service')->controller(ServiceController::class)->group(function () {
        Route::get('/lang-{lang}', 'getAllServicesByLang'); // get ALL services by language
        Route::get('/', 'getAllServices'); // get ALL services
        Route::get('/{id}', 'getSingleService'); // get ONE service
        Route::post('/', 'addService')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']); // add ONE service
        Route::post('/{id}', 'updateService')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']); // modify ONE service (POST is used for updates as Laravel doesn't support file uploads via PUT)
        Route::delete('/{id}', 'deleteService')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']); // delete ONE service
    });

    // REVIEW ROUTES
    Route::prefix('review')->controller(ReviewController::class)->group(function () {
        Route::get('/', 'getAllReviews');
        Route::get('/user', 'getAllUserReviews')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::get('/{id}', 'getSingleReview')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::post('/', 'addReview')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::post('/{id}', 'updateReview')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::delete('/{id}', 'deleteReview')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
    });

    // LANGUAGE ROUTES
    Route::prefix('language')->controller(LanguageController::class)->group(function () {
        Route::get('/', 'getAllLanguages');
        Route::get('/{id}', 'getSingleLanguage');
        Route::post('/', 'addLanguage')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':master', ]);
        Route::post('/{id}', 'updateLanguage')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':master', ]);
        Route::delete('/{id}', 'deleteLanguage')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':master', ]);
    });

    Route::prefix('rooms-category')->controller(RoomsCategoryController::class)->group(function () {
        Route::get('/lang-{lang}', 'getAllCategoriesByLang'); // Liste toutes les catégories by language
        Route::get('/', 'getAllCategories'); // Liste toutes les catégories
        Route::post('/', 'addCategory'); // Crée une nouvelle catégorie
        Route::get('/{id}', 'getSingleCategory')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']); // Affiche une catégorie spécifique
        Route::post('/{id}', 'updateCategory')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']); // Met à jour une catégorie
        Route::delete('/{id}', 'deleteCategory')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']); // Supprime une catégorie
    });

    Route::prefix('room')->controller(RoomController::class)->group(function () {
        Route::get('/lang-{lang}', 'getAllRoomsByLang');
        Route::get('/lang-{lang}/available', 'getAllRoomsAvailableByLang');
        Route::get('/', 'getAllRooms');
        Route::post('/', 'addRoom')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']);
        Route::get('/{id}', 'getSingleRoom');
        Route::post('/{id}', 'updateRoom')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']);
        Route::delete('/{id}', 'deleteRoom')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']);
    });

    Route::prefix('rooms-feature')->controller(RoomsFeatureController::class)->group(function () {
        Route::get('/lang-{lang}', 'getAllFeaturesByLang');
        Route::get('/', 'getAllFeatures');
        Route::post('/', 'addFeature')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']);
        Route::get('/{id}', 'getSingleFeature');
        Route::post('/{id}', 'updateFeature')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']);
        Route::delete('/{id}', 'deleteFeature')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager']);
    });

});

