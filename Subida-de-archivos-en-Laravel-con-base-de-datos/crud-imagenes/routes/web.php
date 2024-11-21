<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ImageController;

Route::resource('images', ImageController::class);