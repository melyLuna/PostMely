<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;

Route::resource('categories', CategoryController::class);
Route::resource('posts', PostController::class);