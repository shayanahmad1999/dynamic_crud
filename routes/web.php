<?php

use App\Http\Controllers\DynamicCrudController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [DynamicCrudController::class, 'read']);
Route::post('/create', [DynamicCrudController::class, 'create']);
Route::get('/edit/{id}', [DynamicCrudController::class, 'edit']);
Route::post('/update/{id}', [DynamicCrudController::class, 'update']);
Route::get('/delete/{id}', [DynamicCrudController::class, 'delete']);

Route::get('/using-ajax', [DynamicCrudController::class, 'read'])->name('ajax.index');