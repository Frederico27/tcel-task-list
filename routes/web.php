<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Added routes for admin
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/task', [App\Http\Controllers\AdminController::class, 'taskList'])->name('admin.taskList');
Route::post('/admin/approve/{id}', [App\Http\Controllers\AdminController::class, 'approveDocument'])->name('admin.approveDocument');
Route::post('/admin/reject/{id}', [App\Http\Controllers\AdminController::class, 'rejectDocument'])->name('admin.rejectDocument');
Route::post('/admin', [App\Http\Controllers\AdminController::class, 'addDocument'])->name('admin.addDocument');
Route::delete('/admin/{id}', [App\Http\Controllers\AdminController::class, 'deleteDocument'])->name('admin.deleteDocument');

//Added routes for user
Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
Route::post('/user/{id}/upload', [App\Http\Controllers\UserController::class, 'uploadDocument'])->name('user.uploadDocument');
