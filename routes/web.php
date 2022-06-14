<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\_3dsController;
use App\Http\Controllers\MPGSController;

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

Route::get('/authenticating_enrolled_cards', [_3dsController::class,'AuthenticatingEnrolledCards'])->name('authenticating_enrolled_cards');
Route::get('/mpgs/payment/{data}', [MPGSController::class,'PaymentView'])->name('payment_view');
Route::post('/payment_redirect', [MPGSController::class,'PaymentRedirect'])->name('payment_redirect');

