<?php

use App\Http\Controllers\Api\AdvertiseController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ClubController;
use App\Http\Controllers\Api\LeagueController;
use App\Http\Controllers\Api\LiveController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Support\Facades\Route;


Route::get('/posts', [PostController::class, 'index'])->name('site.posts.index');
Route::get('/post/{post}', [PostController::class, 'getPostInfo'])->name('site.post.info');
Route::get('/archive/{category}', [PostController::class, 'getPostsPerCategory'])->name('site.archive');
Route::get('/leagues', [LeagueController::class, 'index'])->name('site.leagues.index');
Route::get('/leagues/{league}', [LeagueController::class, 'getLeagueInfo'])->name('site.league.info');
Route::get('/step/{step}', [LeagueController::class, 'getStepInfo'])->name('site.step.info');
Route::get('/lives', [LiveController::class, 'index'])->name('site.lives.index');
Route::get('/advertise', [AdvertiseController::class, 'index'])->name('site.advertise.index');
Route::get('/active-categories', [CategoryController::class, 'getActives'])->name('site.active-categories');
Route::get('/tags-random', [TagController::class, 'getRandom'])->name('site.tags-random');
Route::get('/tag/{tag}', [TagController::class, 'index'])->name('site.tags-random');
Route::get('/club/{club}', [ClubController::class, 'getInfo'])->name('site.club-info');
Route::post('/search', [PostController::class, 'search'])->name('site.posts.search');
Route::get('/pages', [PageController::class, 'getActivePages'])->name('site.active-pages.search');
Route::get('/page/{slug}', [PageController::class, 'getActivePage'])->name('site.active-page.search');

// Route::middleware(['auth:sanctum'])->post('/logout', [AuthController::class, 'logout'])
//                 ->middleware('auth')
//                 ->name('logout');
