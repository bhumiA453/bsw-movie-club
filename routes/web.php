<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\SeatingController;
use App\Http\Controllers\BookingController; 

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/admin/login', function () {
    return view('login');
});

Route::get('/', [FrontendController::class, 'get_movie'])->name('home');
Route::post('/check-seats', [FrontendController::class, 'check_seats'])->name('check-seats');
Route::get('/booking', [FrontendController::class, 'get_seats'])->name('booking');
Route::post('/save-seat-data', [FrontendController::class, 'save_booking'])->name('save-seat-data');

Route::get('send-mail', function () {
   
    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];
   
    \Mail::to('shahbhumik5693@gmail.com')->send(new \App\Mail\MyTestMail($details));
   
    dd("Email is Sent.");
});

Auth::routes();

Route::middleware(['web'])->group(function () {
    // Routes that require authentication
    Route::post('/save_login', [AdminController::class, 'check_login'])->name('check-login');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    // Add more admin routes here
});

Route::middleware(['auth'])->group(function () {
    // Routes that require authentication
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /*Movie menu*/
    Route::get('/movie', [MovieController::class, 'get_all_movie'])->name('movie');
    Route::get('/create', [MovieController::class, 'add_movie'])->name('create');
    Route::post('/save_movie', [MovieController::class, 'save_movie'])->name('save-movie');
    Route::get('/edit/{id}', [MovieController::class, 'edit_movie'])->name('edit-movie');
    Route::post('/delete_movie/{id}', [MovieController::class, 'delete_movie'])->name('delete-movie');
    Route::post('/update/{id}', [MovieController::class, 'update_movie'])->name('update');

    /*Seating menu*/
    Route::get('/seating', [SeatingController::class, 'get_all_seating'])->name('seating');
    Route::get('/create-seats', [SeatingController::class, 'add_seats'])->name('create-seats');
    Route::post('/save_seats', [SeatingController::class, 'save_seats'])->name('save-seat-data');

    /*Booking Menu*/
    Route::get('/get-booking-data', [BookingController::class, 'get_all_booking'])->name('get-booking-data');
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
