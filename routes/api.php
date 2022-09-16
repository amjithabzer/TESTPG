<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\_3dsController;
use App\Http\Controllers\MPGSController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/authorization',[ApiController::class,'CreateAuthorization'])->name('authorization');
Route::post('/payment',[ApiController::class,'Payment'])->name('Payment')->name('payment');
Route::post('/payer_authentication',[ApiController::class,'PayerAuthentication'])->name('payer_authentication');
Route::post('/payer_authentication_validation',[ApiController::class,'PayerAuthenticationValidation'])->name('payer_authentication_validation');
Route::post('/payer_entrollment',[ApiController::class,'PayerEntrollment'])->name('payer_entrollment');
Route::post('/payer_authentication_payment',[ApiController::class,'PaymentAuthorizationValidationPayment'])->name('payer_authentication_payment');
Route::prefix('3ds')->group(function () {
    Route::post('/payer_authentication', [_3dsController::class,'PayerAuthenticationSetup'])->name('3ds_payer_auth');
    Route::post('/device_data_collection', [_3dsController::class,'DeviceDataCollection'])->name('device_data_collection');
    Route::post('/check_entrollement', [_3dsController::class,'CheckEntrollement'])->name('check_entrollement');
    Route::post('/authenticating_enrolled_cards', [_3dsController::class,'AuthenticatingEnrolledCards'])->name('authenticating_enrolled_cards');
    Route::post('/authorization_with_payer_auth_validation', [_3dsController::class,'AuthorizationWithPayerAuthValidation'])->name('authorization_with_payer_auth_validation');
    //for client mids device data collection
    Route::post('/device_data_collection_outside/{org_id}/{api_key}/{secret}', [_3dsController::class,'DeviceDataCollectionOutSide'])->name('device_data_collection_outside');

});
Route::prefix('MPGS')->group(function () {
    Route::post('/create_token', [MPGSController::class,'CreateApiToken'])->name('create_api_token');
    Route::prefix('3ds')->group(function () {
        Route::post('/create_session', [MPGSController::class,'CreateSession'])->name('create_session');
        Route::post('/update_session', [MPGSController::class,'UpdateSession'])->name('update_session');
        Route::post('/create_token', [MPGSController::class,'CreateToken'])->name('create_token');
        Route::post('/payment_authorization', [MPGSController::class,'PaymentAuthorization'])->name('payment_authorization');
        Route::post('/acs_validation/{_3dsid}', [MPGSController::class,'ProcessACSResult'])->name('acs_validation');
        Route::post('/payer_authentication/{OrderId}/{TransactionId}', [MPGSController::class,'PayerAuthentication'])->name('PayerAuthentication');
        Route::post('/pay_request/{OrderId}/{TransactionId}/{session_id}', [MPGSController::class,'PaymentRequest'])->name('PaymentRequest');
    });

});
