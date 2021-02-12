<?php

use App\Http\Controllers\CustomEmailController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('authorized')->group(function() {
    Route::post('send', [ CustomEmailController::class, 'store'  ]);
    Route::get('list', [ CustomEmailController::class, 'index'  ]);
});
