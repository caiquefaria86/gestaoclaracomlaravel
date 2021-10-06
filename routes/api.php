<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::get('/clientes/{user_id}', [App\Http\Controllers\API\ClientsController::class, 'index'])->name('api.dashboard.clients.index');
