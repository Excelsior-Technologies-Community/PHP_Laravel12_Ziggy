<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteStudioController;

/*
|--------------------------------------------------------------------------
| Web Page Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

/*
|--------------------------------------------------------------------------
| Parameter Routes
|--------------------------------------------------------------------------
*/
Route::get('/user/{id}', function ($id) {
    return view('user', compact('id'));
})->name('user.profile');

Route::get('/product/{id?}', function ($id = null) {
    return view('product', compact('id'));
})->name('product.show');

Route::get('/post/{category}/{slug}', function ($category, $slug) {
    return view('post', [
        'category' => $category,
        'slug' => $slug
    ]);
})->name('post.details');

/*
|--------------------------------------------------------------------------
| Existing Tools
|--------------------------------------------------------------------------
*/
Route::get('/route-inspector', function () {
    return view('route-inspector');
})->name('route.inspector');

Route::get('/route-playground', function () {
    return view('route-playground');
})->name('route.playground');

Route::get('/favorites', function () {
    return view('favorites');
})->name('favorites');

Route::get('/route-tester', function () {
    return view('route-tester');
})->name('route.tester');

/*
|--------------------------------------------------------------------------
| Feature 1: Live Interactive API Request Dispatcher & Response Studio
|--------------------------------------------------------------------------
*/
Route::get('/route-dispatcher', [RouteStudioController::class, 'dispatcher'])
    ->name('route.dispatcher');

/*
|--------------------------------------------------------------------------
| Feature 4: Multi-Framework Code Snippet Studio
|--------------------------------------------------------------------------
*/
Route::get('/route-snippets', [RouteStudioController::class, 'snippets'])
    ->name('route.snippets');

/*
|--------------------------------------------------------------------------
| Feature 5: Real-Time Fuzzy Route Search & Visual Namespace Tree Map
|--------------------------------------------------------------------------
*/
Route::get('/route-tree', [RouteStudioController::class, 'tree'])
    ->name('route.tree');

/*
|--------------------------------------------------------------------------
| Feature 6: Client-Side Route Telemetry & Usage Analytics Radar
|--------------------------------------------------------------------------
*/
Route::get('/route-telemetry', [RouteStudioController::class, 'telemetry'])
    ->name('route.telemetry');

/*
|--------------------------------------------------------------------------
| Feature 7: Executive Route Architecture Cheat Sheet & Printable Manual
|--------------------------------------------------------------------------
*/
Route::get('/route-cheatsheet', [RouteStudioController::class, 'cheatsheet'])
    ->name('route.cheatsheet');

/*
|--------------------------------------------------------------------------
| Real JSON API Endpoints for Dispatcher Testing & Consumption
|--------------------------------------------------------------------------
*/
Route::prefix('api')->group(function () {
    Route::get('/users', [RouteStudioController::class, 'apiUsersIndex'])
        ->name('api.users.index');

    Route::get('/users/{id}', [RouteStudioController::class, 'apiUsersShow'])
        ->name('api.users.show');

    Route::post('/users', [RouteStudioController::class, 'apiUsersStore'])
        ->name('api.users.store');

    Route::get('/products', [RouteStudioController::class, 'apiProductsIndex'])
        ->name('api.products.index');

    Route::get('/products/{id}', [RouteStudioController::class, 'apiProductsShow'])
        ->name('api.products.show');

    Route::post('/products', [RouteStudioController::class, 'apiProductsStore'])
        ->name('api.products.store');

    Route::delete('/products/{id}', [RouteStudioController::class, 'apiProductsDestroy'])
        ->name('api.products.destroy');

    Route::get('/health', [RouteStudioController::class, 'apiHealthCheck'])
        ->name('api.health.check');
});
