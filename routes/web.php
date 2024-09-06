<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssignUserRole;



use App\Http\Controllers\CastIndex;
use App\Http\Controllers\CompanyIndex;
use App\Http\Controllers\EpisodeIndex;
use App\Http\Controllers\GenreIndex;
use App\Http\Controllers\MovieIndex;
use App\Http\Controllers\ProducerIndex;
use App\Http\Controllers\SeasonIndex;
use App\Http\Controllers\SeriesIndex;
use App\Http\Controllers\TagIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified','role:admin'])->prefix('/admin')->name('admin.')->group(function () {
    Route::get('/',[AdminController::class, 'index'])->name('index');
    //movies
    Route::get('movies', [MovieIndex::class, 'index'])->name('movies.index');
    Route::get('movies/create', [MovieIndex::class, 'create'])->name('movies.create');
    route::post('movies', [MovieIndex::class, 'store'])->name('movies.store');
    Route::get('movies/{id}/edit', [MovieIndex::class, 'edit'])->name('movies.edit');
    Route::put('movies/{id}', [MovieIndex::class, 'update'])->name('movies.update');
    Route::delete('movies/{id}', [MovieIndex::class, 'delete'])->name('movies.delete');
    //series
    Route::get('series', [SeriesIndex::class, 'index'])->name('series.index');
    Route::get('series/{serie}/seasons', [SeasonIndex::class, 'index'])->name('seasons.index');
    Route::get('series/{serie}/seasons/{season}/episodes', [EpisodeIndex::class, 'index'])->name('episodes.index');
    //casts
    Route::get('casts', [CastIndex::class, 'index'])->name('casts.index'); 
    //genres
    Route::get('genres', [GenreIndex::class, 'index'])->name('genres.index');
    //tags
    Route::get('tags', [TagIndex::class, 'index'])->name('tags.index');
    //producers
    Route::get('producers', [ProducerIndex::class, 'index'])->name('producers.index');
    //companies
    Route::get('companies', [CompanyIndex::class, 'index'])->name('companies.index');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/assign-role', function () {
        $user = auth()->user();

        if ($user) {
            $user->assignRole('admin');
            return 'Role assigned successfully';
        }

        return 'User not found';
    })->name('assign.role');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
