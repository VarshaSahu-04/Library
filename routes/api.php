<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ApiBookController;
use App\Console\Kernel;


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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/search', [ApiBookController::class, 'SearchBook']);
Route::get('/rent', [ApiBookController::class, 'RentBook']);
Route::get('/return', [ApiBookController::class, 'ReturnBook']);
Route::get('/bookhistory', [ApiBookController::class, 'BookrentalHistory']);
Route::get('/userhistory', [ApiBookController::class, 'UserRentalHistory']);
Route::get('/stats', [ApiBookController::class, 'BookStats']);
Route::get('/overduemail', function () {
    app(Kernel::class)->handleOverdueRentals();
    return 'Overdue rentals processed and emails sent!';
});