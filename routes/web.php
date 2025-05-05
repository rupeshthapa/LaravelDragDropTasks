<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TaskController::class, 'index'])->name('index');
Route::post('/store-task', [TaskController::class, 'store'])->name('store');
Route::delete('/delete-task/{id}', [TaskController::class, 'destroy'])->name('destroy');