<?php

use App\Http\Controllers\MangaController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use Illuminate\Support\Facades\Route;

Route::apiResource('mangas', MangaController::class);
Route::apiResource('authors', AuthorController::class);
Route::apiResource('genres', GenreController::class);

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
 */

Route::get('mangas/{manga}/authors', [MangaController::class, 'authors']);
Route::get('mangas/{manga}/genres', [MangaController::class, 'genres']);
Route::post('mangas/{manga}/authors', [MangaController::class, 'attachAuthor']);
Route::post('mangas/{manga}/genres', [MangaController::class, 'attachGenre']);
Route::delete('mangas/{manga}/authors/{author}', [MangaController::class, 'detachAuthor']);
Route::delete('mangas/{manga}/genres/{genre}', [MangaController::class, 'detachGenre']);
