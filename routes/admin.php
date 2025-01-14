<?php

use Globit\LaravelTicket\Http\Controllers\Admin\LoginController;
use Globit\LaravelTicket\Http\Controllers\Admin\TicketController;
use Illuminate\Support\Facades\Route;

//Route::get('authentication', [LoginController::class, 'login'])->name('login.show');

//Route::post('authentication', action: [LoginController::class, 'doLogin'])->name('login');
//Route::group(['middleware' => ['Admin', 'auth:web']], function () {
Route::get('/ticket', [TicketController::class, 'getMail']);
include('admin/ticket.php');
//});
//Route::post('logout', [LoginController::class, 'logout'])->name('logout'); // Add this line
