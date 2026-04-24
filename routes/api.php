<?php

use App\Http\Controllers\MealController;
use Illuminate\Support\Facades\Route;

Route::get('/meals', [MealController::class, 'index']);
Route::get('/meals/{id}', [MealController::class, 'show']);

