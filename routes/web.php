<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiRouterController;

// This loads your HTML page when you visit http://127.0.0.1:8000
Route::view('/', 'post.page');

// This handles all your JavaScript API calls
Route::match(['get', 'post'], '/api', [ApiRouterController::class, 'handleRequest']);

