<?php

use App\Http\Controllers\CatBreedController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatBreedsImageController;
use App\Http\Controllers\UserAuthController;


Route::post('register', [UserAuthController::class, 'register']);
Route::post('login', [UserAuthController::class, 'login']);
Route::post('logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum');
Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('cat-breeds', CatBreedController::class);
});

Route::get('/popular-cat-breeds-summary', [CatBreedController::class, 'PopularCatsSummary']);
Route::get('/cat-breeds-search', [CatBreedController::class, 'searchCatBreeds']);
Route::get('/searched-cat/{id}', [CatBreedController::class, 'searchedCatBreedDetails']);
Route::get('/popular-cat-breeds', [CatBreedController::class, 'getPopularCatBreeds']);  



//                   Fetching Data From External API

//Route::get('/fetch', [CatBreedController::class, 'fetchCatBreeds']);        
//Route::get('/fetch-images', [CatBreedsImageController::class, 'fetchCatBreedsImages']);        
