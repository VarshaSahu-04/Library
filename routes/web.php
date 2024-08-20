<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\InvoicePaid;
use App\Events\MessageNotification;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RentalController;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/send-mail', function () {
    $invoice = (object) ['id' => 12345]; // Example invoice object
   

Notification::route('mail', 'varshasahu0079@gmail.com')
            ->notify(new InvoicePaid($invoice));

});

Route::get('/event',function(){
    event(new MessageNotification('Hello Varsha'));
});

Route::get('/listen',function(){
    return view('listen');
});


Route::get('/student', [UsersController::class, 'Users'])->name('student');
Route::post('/add', [UsersController::class, 'add'])->name('add');

Route::get('/books', [BookController::class, 'search']);
Route::get('/booklist', [BookController::class, 'list'])->name('booklist');
Route::get('/availablebooks', [RentalController::class, 'availablebooks'])->name('availablebooks');
Route::post('/rentbook', [RentalController::class, 'rentbook'])->name('rentbook');


Route::post('/return', [RentalController::class, 'returnBook']);
Route::get('/history', [RentalController::class, 'rentalHistory']);
Route::get('/stats/most-overdue', [RentalController::class, 'mostOverdue']);
Route::get('/stats/most-popular', [RentalController::class, 'mostPopular']);
Route::get('/stats/least-popular', [RentalController::class, 'leastPopular']);
Route::get('/', [BookController::class, 'list']);
