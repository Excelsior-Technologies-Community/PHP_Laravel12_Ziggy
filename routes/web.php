<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Home Routes
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
| Required Parameter
|--------------------------------------------------------------------------
*/

Route::get('/user/{id}', function ($id) {
    return view('user', compact('id'));
})->name('user.profile');

/*
|--------------------------------------------------------------------------
| Optional Parameter
|--------------------------------------------------------------------------
*/

Route::get('/product/{id?}', function ($id = null) {
    return view('product', compact('id'));
})->name('product.show');

/*
|--------------------------------------------------------------------------
| Multiple Parameters
|--------------------------------------------------------------------------
*/

Route::get('/post/{category}/{slug}', function ($category, $slug) {

    return view('post', [
        'category' => $category,
        'slug' => $slug
    ]);
})->name('post.details');

/*
|--------------------------------------------------------------------------
| Route Inspector
|--------------------------------------------------------------------------
*/

Route::get('/route-inspector', function () {
    return view('route-inspector');
})->name('route.inspector');

/*
|--------------------------------------------------------------------------
| Route Playground
|--------------------------------------------------------------------------
*/

Route::get('/route-playground', function () {
    return view('route-playground');
})->name('route.playground');

/*
|--------------------------------------------------------------------------
| NEW FEATURE : Favorite Routes
|--------------------------------------------------------------------------
*/

Route::get('/favorites', function () {
    return view('favorites');
})->name('favorites');

/*
|--------------------------------------------------------------------------
| NEW FEATURE : Route Tester
|--------------------------------------------------------------------------
*/

Route::get('/route-tester', function () {
    return view('route-tester');
})->name('route.tester');

