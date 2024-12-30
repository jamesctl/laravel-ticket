<?php

use App\Http\Controllers\Admin\UserController;

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::post('avatar/{id}', [UserController::class, 'avatar'])->middleware('permission:user:update');
    Route::post('setting/{id}', [UserController::class, 'setting']);
    Route::post('upload-image/{id}', [UserController::class, 'uploadImage']);
    Route::get('/', [UserController::class, 'index'])->name('index')->middleware('permission:user:view');
    Route::get('/create', [UserController::class, 'create'])->name('create')->middleware('permission:user:create');
    Route::post('/', [UserController::class, 'store'])->name('store')->middleware('permission:user:create');
    Route::get('{user}', [UserController::class, 'show'])->name('show')->middleware('permission:user:view');
    Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit')->middleware('permission:user:view');
    Route::PUT('{user}', [UserController::class, 'update'])->name('update')->middleware('permission:user:update');
    Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy')->middleware('permission:user:delete');
});
