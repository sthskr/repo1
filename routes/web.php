<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;

Route::get('/', [ListingController::class, 'index'])->name("default");

Route::get('/endpoint', [ListingController::class, 'endpoint'])->name("endpoint");
