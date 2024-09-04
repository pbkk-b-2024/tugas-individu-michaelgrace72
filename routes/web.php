<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssignUserRole;


use App\Livewire\CompanyIndex;
use App\Livewire\EpisodeIndex;
use App\Livewire\GenreIndex;
use App\Livewire\MovieIndex;
use App\Livewire\ProducerIndex;
use App\Livewire\SeasonIndex;
use App\Livewire\SeriesIndex;
use App\Livewire\TagIndex;
use App\Livewire\Test;
use App\livewire\CastIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified','role:admin'])->prefix('/admin')->name('admin.')->group(function () {
    Route::get('/',[AdminController::class, 'index'])->name('index');
    Route::get('movies', MovieIndex::class)->name('movies.index');
    Route::get('series', SeriesIndex::class)->name('series.index');
    Route::get('series/{serie}/seasons', SeasonIndex::class)->name('seasons.index');
    Route::get('series/{serie}/seasons/{season}/episodes', EpisodeIndex::class)->name('episodes.index');
    Route::get('casts', CastIndex::class)->name('casts.index'); 
    Route::get('genres', GenreIndex::class)->name('genres.index');
    Route::get('tags', TagIndex::class)->name('tags.index');
    Route::get('producers', ProducerIndex::class)->name('producers.index');
    Route::get('companies', CompanyIndex::class)->name('companies.index');
    Route::get('test',Test::class)->name('test.index');
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
