<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\Admin\LoginController;
//use App\Http\Controllers\Frontend\LoginController as FrontendLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

include('admin.php');

//Route::get('login', [FrontendLoginController::class, 'login'])->name('login');
//Route::post('do-login', [FrontendLoginController::class, 'doLogin'])->name('doLogin');