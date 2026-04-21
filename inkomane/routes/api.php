<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;

// tickets
Route::get('/tickets', [TicketController::class, 'index']);
Route::post('/tickets', [TicketController::class, 'store']);
Route::put('/tickets/{id}', [TicketController::class, 'update']);

// users
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

