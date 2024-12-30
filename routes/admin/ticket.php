<?php

use App\Http\Controllers\Admin\TicketController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function () {
        Route::get('/', [TicketController::class, 'index'])->name('index');
            //->middleware('permission:ticket:view');
        Route::get('/create', [TicketController::class, 'create'])->name('create');
            //->middleware('permission:ticket:create');

        Route::post('/create', [TicketController::class, 'store'])->name('store');
        //->middleware('permission:ticket:create');

        Route::get('{ticket}', [TicketController::class, 'show'])
        ->name('show');
        //->middleware('permission:ticket:view');

        Route::get('show/{ticket}', [TicketController::class, 'showEdit'])
        ->name('showEdit');
        //->middleware('permission:ticket:update');

        Route::put('/', [TicketController::class, 'updateModal'])
        ->name('update_modal');
        //->middleware('permission:ticket:update');

            
        Route::get('{ticket}/edit', [TicketController::class, 'edit'])->name('edit');
            //->middleware('permission:ticket:edit');
        Route::delete('{ticket}', [TicketController::class, 'destroy'])->name('destroy');
            //->middleware('permission:ticket:delete');
        Route::get('/{id}', [TicketController::class, 'show'])->name('show');
        //->middleware('permission:ticket:show');
        Route::post('/reply', [TicketController::class, 'sendReply'])->name('sendReply');
        //->middleware('permission:ticket:reply');
    });
});