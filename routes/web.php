<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index']);
Route::post('/admin', [App\Http\Controllers\AdminController::class, 'addDocument'])->name('admin.addDocument');
Route::delete('/admin/{id}', [App\Http\Controllers\AdminController::class, 'deleteDocument'])->name('admin.deleteDocument');
