<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieIndex;
use App\Http\Controllers\SeriesIndex;
use App\Http\Controllers\SeasonIndex;
use App\Http\Controllers\EpisodeIndex;
use App\Http\Controllers\CastIndex;
use App\Http\Controllers\GenreIndex;
use App\Http\Controllers\TagIndex;
use App\Http\Controllers\ProducerIndex;
use App\Http\Controllers\CompanyIndex;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['api_key'])->group(function(){
    // movies
    // Route::get('movies', [MovieIndex::class, 'showall']);
    Route::get('movies/{id}', [MovieIndex::class, 'show']);
    // series
    // Route::get('series', [SeriesIndex::class, 'showall']);
    Route::get('series/{id}', [SeriesIndex::class, 'show']);
    // seasons
    // Route::get('seasons', [SeasonIndex::class, 'showall']);
    Route::get('seasons/{id}', [SeasonIndex::class, 'show']);
    // episodes
    // Route::get('episodes', [EpisodeIndex::class, 'showall']);
    Route::get('episodes/{id}', [EpisodeIndex::class, 'show']);
    // casts
    // Route::get('casts', [CastIndex::class, 'showall']);
    Route::get('casts/{id}', [CastIndex::class, 'show']);
    // genres
    // Route::get('genres', [GenreIndex::class, 'showall']);
    Route::get('genres/{id}', [GenreIndex::class, 'show']);
    // tags
    // Route::get('tags', [TagIndex::class, 'showall']);
    Route::get('tags/{id}', [TagIndex::class, 'show']);
    // producers
    // Route::get('producers', [ProducerIndex::class, 'showall']);
    Route::get('producers/{id}', [ProducerIndex::class, 'show']);
    // companies
    // Route::get('companies', [CompanyIndex::class, 'showall']);
    Route::get('companies/{id}', [CompanyIndex::class, 'show']);


});

Route::middleware([ 'api_key', 'role:admin'])->group(function(){
    // movies
    Route::post('movies', [MovieIndex::class, 'storeapi']);
    Route::put('movies/{id}', [MovieIndex::class, 'updateapi']);
    Route::delete('movies/{id}', [MovieIndex::class, 'deleteapi']);
    // series
    Route::post('series', [SeriesIndex::class, 'storeapi']);
    Route::put('series/{id}', [SeriesIndex::class, 'updateapi']);
    Route::delete('series/{id}', [SeriesIndex::class, 'deleteapi']);
    // episodes
    Route::post('episodes', [EpisodeIndex::class, 'storeapi']);
    Route::put('episodes/{id}', [EpisodeIndex::class, 'updateapi']);
    Route::delete('episodes/{id}', [EpisodeIndex::class, 'deleteapi']);
    // seasons
    Route::post('seasons', [SeasonIndex::class, 'storeapi']);
    Route::put('seasons/{id}', [SeasonIndex::class, 'updateapi']);
    Route::delete('seasons/{id}', [SeasonIndex::class, 'deleteapi']);
    // casts
    Route::post('casts', [CastIndex::class, 'storeapi']);
    Route::put('casts/{id}', [CastIndex::class, 'updateapi']);
    Route::delete('casts/{id}', [CastIndex::class, 'deleteapi']);
    // genres
    Route::post('genres', [GenreIndex::class, 'storeapi']);
    Route::put('genres/{id}', [GenreIndex::class, 'updateapi']);
    Route::delete('genres/{id}', [GenreIndex::class, 'deleteapi']);
    // tags
    Route::post('tags', [TagIndex::class, 'storeapi']);
    Route::put('tags/{id}', [TagIndex::class, 'updateapi']);
    Route::delete('tags/{id}', [TagIndex::class, 'deleteapi']);
    // producers
    Route::post('producers', [ProducerIndex::class, 'storeapi']);
    Route::put('producers/{id}', [ProducerIndex::class, 'updateapi']);
    Route::delete('producers/{id}', [ProducerIndex::class, 'deleteapi']);
    // companies
    Route::post('companies', [CompanyIndex::class, 'storeapi']);
    Route::put('companies/{id}', [CompanyIndex::class, 'updateapi']);
    Route::delete('companies/{id}', [CompanyIndex::class, 'deleteapi']);


});
