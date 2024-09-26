<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieIndex;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('movies', [MovieIndex::class, 'showall']);
Route::get('movies/{id}', [MovieIndex::class, 'show']);

Route::middleware(['auth:sanctum', 'verified', 'role:admin'])->group(function(){
    Route::post('movies', [MovieIndex::class, 'storeapi']);
    Route::put('movies/{id}', [MovieIndex::class, 'updateapi']);
    Route::delete('movies/{id}', [MovieIndex::class, 'deleteapi']);
});
