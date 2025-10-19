<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('https://e-portal.telkomcel.tl/app/ext/tasklist/audit/admin');
});


//make group route with middleware sso.auth
Route::middleware(['sso.auth'])->group(function () {
    //Added routes for admin
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index')->middleware('admin');

    Route::middleware(['admin.task'])->group(function () {
        Route::get('/admin/task', [App\Http\Controllers\AdminController::class, 'taskList'])->name('admin.taskList');
        Route::post('/admin/approve/{id}', [App\Http\Controllers\AdminController::class, 'approveDocument'])->name('admin.approveDocument');
        Route::post('/admin/reject/{id}', [App\Http\Controllers\AdminController::class, 'rejectDocument'])->name('admin.rejectDocument');
        Route::post('/admin/approve-bulk', [App\Http\Controllers\AdminController::class, 'bulkApprove'])->name('admin.bulkApprove');
        Route::post('/admin', [App\Http\Controllers\AdminController::class, 'addDocument'])->name('admin.addDocument');
        Route::put('/admin/{id}', [App\Http\Controllers\AdminController::class, 'updateDocument'])->name('admin.updateDocument');
        Route::delete('/admin/{id}', [App\Http\Controllers\AdminController::class, 'deleteDocument'])->name('admin.deleteDocument');
        Route::post('/admin/generate-task/{id}', [App\Http\Controllers\AdminController::class, 'generateDocumentTask'])->name('admin.generateDocumentTask');
    });
    //Added routes for user

    Route::middleware(['user'])->group(function () {
        Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
        Route::post('/user/{id}/upload', [App\Http\Controllers\UserController::class, 'uploadDocument'])->name('user.uploadDocument');
    });

    //Added routes for superadmin
    Route::get('/superadmin', [SuperAdminController::class, 'index'])->name('superadmin.index')->middleware('superadmin');
    Route::get('/documents/{id}/view', [DocumentController::class, 'view'])->name('docs.view');


    // API route to fetch employees
    Route::get('/api/employees', [App\Http\Controllers\AdminController::class, 'apiEmployees'])->name('api.employees');
});
