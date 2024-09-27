<?php

use App\Http\Controllers\AdminController;

use App\Http\Controllers\CastIndex;
use App\Http\Controllers\CompanyIndex;
use App\Http\Controllers\EpisodeIndex;
use App\Http\Controllers\GenreIndex;
use App\Http\Controllers\MovieIndex;
use App\Http\Controllers\ProducerIndex;
use App\Http\Controllers\SeasonIndex;
use App\Http\Controllers\SeriesIndex;
use App\Http\Controllers\TagIndex;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->prefix('/admin')->name('admin.')->group(function () {

    Route::get('/',[AdminController::class, 'index'])->name('index');
    
    Route::get('movies', [MovieIndex::class, 'index'])->name('movies.index');
    Route::get('movies/{id}/overview', [MovieIndex::class, 'show'])->name('movies.show');

    Route::get('series', [SeriesIndex::class, 'index'])->name('series.index');
    Route::get('series/{id}/overview', [SeriesIndex::class, 'show'])->name('series.show');

    Route::get('series/{serie}/seasons', [SeasonIndex::class, 'index'])->name('seasons.index');
    Route::get('series/{serie}/seasons/{season}/overview', [SeasonIndex::class, 'show'])->name('seasons.show');

    Route::get('casts', [CastIndex::class, 'index'])->name('casts.index'); 
    Route::get('casts/{id}/overview', [CastIndex::class, 'show'])->name('casts.show');

    Route::get('genres', [GenreIndex::class, 'index'])->name('genres.index');
    Route::get('genres/{id}/overview', [GenreIndex::class, 'show'])->name('genres.show');

    Route::get('tags', [TagIndex::class, 'index'])->name('tags.index');
    Route::get('tags/{id}/overview', [TagIndex::class, 'show'])->name('tags.show');

    Route::get('producers', [ProducerIndex::class, 'index'])->name('producers.index');
    Route::get('producers/{id}/overview', [ProducerIndex::class, 'show'])->name('producers.show');

    Route::get('companies', [CompanyIndex::class, 'index'])->name('companies.index');
    Route::get('companies/{id}/overview', [CompanyIndex::class, 'show'])->name('companies.show');
});
Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified', 'role:admin'])->prefix('/admin')->name('admin.')->group(function () {
    //movies
    Route::get('movies/create', [MovieIndex::class, 'create'])->name('movies.create');
    route::post('movies', [MovieIndex::class, 'store'])->name('movies.store');
    Route::get('movies/{id}/edit', [MovieIndex::class, 'edit'])->name('movies.edit');
    Route::put('movies/{id}', [MovieIndex::class, 'update'])->name('movies.update');
    Route::delete('movies/{id}', [MovieIndex::class, 'delete'])->name('movies.delete');
    //series
    Route::get('series/create', [SeriesIndex::class, 'create'])->name('series.create');
    Route::post('series', [SeriesIndex::class, 'store'])->name('series.store');
    Route::get('series/{id}/edit', [SeriesIndex::class, 'edit'])->name('series.edit');
    Route::put('series/{id}', [SeriesIndex::class, 'update'])->name('series.update');
    Route::delete('series/{id}', [SeriesIndex::class, 'destroy'])->name('series.delete');
    //seasons
    Route::get('series/{serie}/seasons/create', [SeasonIndex::class, 'create'])->name('seasons.create');
    Route::post('series/{serie}/seasons', [SeasonIndex::class, 'store'])->name('seasons.store');
    Route::get('series/{serie}/seasons/{season}/edit', [SeasonIndex::class, 'edit'])->name('seasons.edit');
    Route::put('series/{serie}/seasons/{season}', [SeasonIndex::class, 'update'])->name('seasons.update');
    Route::delete('series/{serie}/seasons/{season}', [SeasonIndex::class, 'destroy'])->name('seasons.delete');
    //episodes
    Route::get('series/{serie}/seasons/{season}/episodes', [EpisodeIndex::class, 'index'])->name('episodes.index');
    Route::get('series/{serie}/seasons/{season}/episodes/create', [EpisodeIndex::class, 'create'])->name('episodes.create');
    Route::post('series/{serie}/seasons/{season}/episodes', [EpisodeIndex::class, 'store'])->name('episodes.store');
    Route::get('series/{serie}/seasons/{season}/episodes/{episode}/edit', [EpisodeIndex::class, 'edit'])->name('episodes.edit');
    Route::delete('series/{serie}/seasons/{season}/episodes/{episode}', [EpisodeIndex::class, 'destroy'])->name('episodes.delete');
    //casts
    Route::get('casts/create', [CastIndex::class, 'create'])->name('casts.create');
    Route::post('casts', [CastIndex::class, 'generateCast'])->name('casts.generate');
    Route::get('casts/{id}/edit', [CastIndex::class, 'edit'])->name('casts.edit');
    Route::put('casts/{id}', [CastIndex::class, 'update'])->name('casts.update');
    Route::delete('casts/{id}', [CastIndex::class, 'destroy'])->name('casts.delete');
    //genres
    Route::get('genres/create', [GenreIndex::class, 'create'])->name('genres.create');
    route::post('genres', [GenreIndex::class, 'store'])->name('genres.store');
    Route::get('genres/{id}/edit', [GenreIndex::class, 'edit'])->name('genres.edit');
    Route::put('genres/{id}', [GenreIndex::class, 'update'])->name('genres.update');
    Route::delete('genres/{id}', [GenreIndex::class, 'destroy'])->name('genres.delete');
    
    //tags
    Route::get('tags/create', [TagIndex::class, 'create'])->name('tags.create');
    route::post('tags', [TagIndex::class, 'store'])->name('tags.store');
    Route::get('tags/{id}/edit', [TagIndex::class, 'edit'])->name('tags.edit');
    Route::put('tags/{id}', [TagIndex::class, 'update'])->name('tags.update');
    Route::delete('tags/{id}', [TagIndex::class, 'delete'])->name('tags.delete');
    
    //producers
    Route::get('producers/create', [ProducerIndex::class, 'create'])->name('producers.create');
    route::post('producers', [ProducerIndex::class, 'store'])->name('producers.store');
    Route::get('producers/{id}/edit', [ProducerIndex::class, 'edit'])->name('producers.edit');
    Route::put('producers/{id}', [ProducerIndex::class, 'update'])->name('producers.update');
    Route::delete('producers/{id}', [ProducerIndex::class, 'delete'])->name('producers.delete');
    //companies
    Route::get('companies/create', [CompanyIndex::class, 'create'])->name('companies.create');
    route::post('companies', [CompanyIndex::class, 'store'])->name('companies.store');
    Route::get('companies/{id}/edit', [CompanyIndex::class, 'edit'])->name('companies.edit');
    Route::put('companies/{id}', [CompanyIndex::class, 'update'])->name('companies.update');
    Route::delete('companies/{id}', [CompanyIndex::class, 'delete'])->name('companies.delete');

});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/dashboard', function () {
        if(auth()->user()->hasRole('admin')){
            return redirect()->route('admin.index');
        }
        return view('dashboard');})->name('dashboard');
    Route::get('/documentation', function () {
        return view('documentation');
    })->name('documentation');
    Route::post('/user/api-key/regenerate', [UserController::class, 'generateApiKey'])
    ->name('user.api-key.regenerate')
    ->middleware('auth');
});
