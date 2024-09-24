<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AjaxModalController;
use App\Http\Controllers\AjaxSeparateController;
use App\Http\Controllers\DynamicCrudController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [DynamicCrudController::class, 'read'])->name('read');
Route::post('/create', [DynamicCrudController::class, 'create']);
Route::get('/edit/{id}', [DynamicCrudController::class, 'edit']);
Route::post('/update/{id}', [DynamicCrudController::class, 'update']);
Route::get('/delete/{id}', [DynamicCrudController::class, 'delete']);

Route::get('/using-ajax', [AjaxController::class, 'index'])->name('ajax.index');
Route::post('/using-ajax', [AjaxController::class, 'store'])->name('ajax.store');
Route::get('/delete/{id}', [AjaxController::class, 'destroy'])->name('ajax.delete');
Route::get('/edit/{id}', [AjaxController::class, 'edit'])->name('ajax.edit');
Route::get('/pagination', [AjaxController::class, 'pagination'])->name('ajax.pagination');
Route::get('/search', [AjaxController::class, 'search'])->name('ajax.search');

Route::get('items', [AjaxModalController::class, 'index'])->name('ajax.modal');
Route::get('items/create', [AjaxModalController::class, 'create'])->name('items.create');
Route::post('items', [AjaxModalController::class, 'store'])->name('items.store');
Route::get('items/{item}/edit', [AjaxModalController::class, 'edit'])->name('items.edit');
Route::put('items/{item}', [AjaxModalController::class, 'update'])->name('items.update');
Route::delete('items/{item}', [AjaxModalController::class, 'destroy'])->name('items.destroy');
Route::get('items/search', [AjaxModalController::class, 'search'])->name('items.search');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');