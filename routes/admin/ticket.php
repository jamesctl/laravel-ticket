<?php

use Globit\LaravelTicket\Http\Controllers\Admin\TicketController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function () {
        Route::get('/', [TicketController::class, 'index'])->name('index');
        Route::get('/create', [TicketController::class, 'create'])->name('create');
        Route::post('/create', [TicketController::class, 'store'])->name('store');
        Route::get('{ticket}', [TicketController::class, 'show'])->name('show');
        Route::get('show/{ticket}', [TicketController::class, 'showEdit'])->name('showEdit');
        Route::put('/', [TicketController::class, 'updateModal'])->name('update_modal');
        Route::get('{ticket}/edit', [TicketController::class, 'edit'])->name('edit');
        Route::delete('{ticket}', [TicketController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [TicketController::class, 'show'])->name('show');
        Route::post('/reply', [TicketController::class, 'sendReply'])->name('sendReply');
    });
});