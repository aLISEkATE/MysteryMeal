<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\MealController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserRecipeController; 
use App\Http\Controllers\FavoriteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/recipes', [MealController::class, 'recipes'])->name('recipes');
Route::get('/recipe/api/{id}', [MealController::class, 'viewApiRecipe'])->name('recipe.api.view');
Route::get('/recipe/{id}', [MealController::class, 'viewRecipe'])->name('recipe.view');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/minigame', function () {
    return view('minigame/minigame');
})->middleware(['auth', 'verified']);
Route::get("/minigame/gameover", [ScoreController::class, 'gameover'])->middleware(['auth', 'verified']);

Route::post('/scores', [ScoreController::class, 'store'])->name('scores.store');
Route::get('/scores', [ScoreController::class, 'index'])->name('scores.index');


Route::resource('my-recipes', UserRecipeController::class)->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::post('/favorites/{mealId}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{mealId}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
});

require __DIR__.'/auth.php';
