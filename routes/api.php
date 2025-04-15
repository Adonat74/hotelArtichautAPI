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
    'throttle:100,1',
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
        Route::post('/', 'addPayment')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::post('/checkout', 'checkout')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class.':user']);
        Route::post('/add-services/booking-{id}', 'addServicesToBooking')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::get('/qr-code', 'sendQrCode')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::post('/total-price', 'getTotalPrice')->middleware();
    });

    // ADMIN PAYMENT ROUTES
    Route::prefix('admin/payment')->controller(BookingController::class)->group(function () {
        Route::get('/', 'getAllPayments')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager', ]);
        Route::get('/booking-{id}', 'getAllBookingPayments')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager', ]);
        Route::get('/{id}', 'getSinglePayment')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager', ]);
        Route::post('/', 'addPayment')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager', ]);
        Route::post('/{id}', 'updatePayment')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager', ]);
        Route::delete('/{id}', 'deletePayment')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager', ]);
    });


    ////////////////////////// AUTHENTICATION //////////////////////////
    // AUTH ROUTES
    Route::post('/login', [AuthController::class, 'login'])->middleware();
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
        Route::get('/', 'getAllUsers')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':employee', ]);
        Route::get('/{id}', 'getSingleUser')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':employee', ]);
        Route::post('/', 'addUser')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager', ]);
        Route::post('/{id}', 'updateUser')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager', ]);
        Route::delete('/{id}', 'deleteUser')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':manager', ]);
    });

    // ROLE ROUTES
    Route::prefix('role')->controller(RoleController::class)->group(function () {
        Route::get('/', 'getAllRoles')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':master', ]);
        Route::get('/{id}', 'getSingleRole')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':master', ]);
        Route::post('/', 'addRole')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':master', ]);
        Route::post('/{id}', 'updateRole')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':master', ]);
        Route::delete('/{id}', 'deleteRole')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':master', ]);
    });


    ///////////// CMS /////////////////////
    // CONTENT ROUTES
    Route::prefix('content')->controller(ContentController::class)->group(function () {
        Route::get('/lang-{lang}', 'getAllContentsByLang')->middleware(); // get ALL contents by language
        Route::get('/', 'getAllContents')->middleware(); // get ALL contents
        Route::get('/{id}', 'getSingleContent')->middleware(); // get ONE Content

        Route::post('/', 'addContent')->middleware(); // add ONE Content
        Route::post('/{id}', 'updateContent')->middleware(); // modify ONE Content (POST is used for updates as Laravel doesn't support file uploads via PUT)
        Route::delete('/{id}', 'deleteContent')->middleware(); // delete ONE Content
    });

    // NEWS ARTICLES ROUTES
    Route::prefix('news')->controller(NewsArticleController::class)->group(function () {
        Route::get('/lang-{lang}', 'getAllNewsArticlesByLang')->middleware(); // get ALL news by language
        Route::get('/', 'getAllNewsArticles')->middleware(); // get ALL news
        Route::get('/{id}', 'getSingleNewsArticle')->middleware(); // get ONE news
        Route::post('/', 'addNewsArticle')->middleware(); // add ONE news
        Route::post('/{id}', 'updateNewsArticle')->middleware(); // modify ONE news (POST is used for updates as Laravel doesn't support file uploads via PUT)
        Route::delete('/{id}', 'deleteNewsArticle')->middleware(); // delete ONE news
    });

    // SERVICE ROUTES
    Route::prefix('service')->controller(ServiceController::class)->group(function () {
        Route::get('/lang-{lang}', 'getAllServicesByLang')->middleware(); // get ALL services by language
        Route::get('/', 'getAllServices')->middleware(); // get ALL services
        Route::get('/{id}', 'getSingleService')->middleware(); // get ONE service
        Route::post('/', 'addService')->middleware(); // add ONE service
        Route::post('/{id}', 'updateService')->middleware(); // modify ONE service (POST is used for updates as Laravel doesn't support file uploads via PUT)
        Route::delete('/{id}', 'deleteService')->middleware(); // delete ONE service
    });

    // REVIEW ROUTES
    Route::prefix('review')->controller(ReviewController::class)->group(function () {
        Route::get('/', 'getAllReviews')->middleware();
        Route::get('/user', 'getAllUserReviews')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::get('/{id}', 'getSingleReview')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::post('/', 'addReview')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::post('/{id}', 'updateReview')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
        Route::delete('/{id}', 'deleteReview')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':user', ]);
    });

    // LANGUAGE ROUTES
    Route::prefix('language')->controller(LanguageController::class)->group(function () {
        Route::get('/', 'getAllLanguages')->middleware();
        Route::get('/{id}', 'getSingleLanguage')->middleware();
        Route::post('/', 'addLanguage')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':master', ]);
        Route::post('/{id}', 'updateLanguage')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':master', ]);
        Route::delete('/{id}', 'deleteLanguage')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class . ':master', ]);
    });

    Route::prefix('rooms-category')->controller(RoomsCategoryController::class)->group(function () {
        Route::get('/lang-{lang}', 'getAllCategoriesByLang')->middleware(); // Liste toutes les catégories by language
        Route::get('/', 'getAllCategories')->middleware(); // Liste toutes les catégories
        Route::post('/', 'addCategory')->middleware(); // Crée une nouvelle catégorie
        Route::get('/{id}', 'getSingleCategory')->middleware(); // Affiche une catégorie spécifique
        Route::post('/{id}', 'updateCategory')->middleware(); // Met à jour une catégorie
        Route::delete('/{id}', 'deleteCategory')->middleware(); // Supprime une catégorie
    });

    Route::prefix('room')->controller(RoomController::class)->group(function () {
        Route::get('/lang-{lang}', 'getAllRoomsByLang')->middleware();
        Route::get('/lang-{lang}/available', 'getAllRoomsAvailableByLang')->middleware();
        Route::get('/', 'getAllRooms')->middleware();
        Route::post('/', 'addRoom')->middleware();
        Route::get('/{id}', 'getSingleRoom')->middleware();
        Route::post('/{id}', 'updateRoom')->middleware();
        Route::delete('/{id}', 'deleteRoom')->middleware();
    });

    Route::prefix('rooms-feature')->controller(RoomsFeatureController::class)->group(function () {
        Route::get('/lang-{lang}', 'getAllFeaturesByLang')->middleware();
        Route::get('/', 'getAllFeatures')->middleware();
        Route::post('/', 'addFeature')->middleware();
        Route::get('/{id}', 'getSingleFeature')->middleware();
        Route::post('/{id}', 'updateFeature')->middleware();
        Route::delete('/{id}', 'deleteFeature')->middleware();
    });

});

