<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Route with parameters example
Route::get('/user/{id}', function ($id) {
    return view('user', ['id' => $id]);
})->name('user.profile');

// Optional parameter example
Route::get('/product/{id?}', function ($id = null) {
    return view('product', ['id' => $id]);
})->name('product.show');

// Multiple parameters example
Route::get('/post/{category}/{slug}', function ($category, $slug) {
    return view('post', [
        'category' => $category,
        'slug' => $slug
    ]);
})->name('post.details');