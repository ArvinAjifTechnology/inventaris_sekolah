<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Gate;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



Route::middleware('admin')->group(function () {
    // route yang hanya bisa diakses oleh admin
    Route::resource('/admin/users', UserController::class)->names('admin.users');
    Route::resource('/admin/rooms', RoomController::class);
    Route::resource('/admin/items', ItemController::class);
    Route::resource('/admin/borrows', BorrowController::class);
    Route::put('/admin/borrows/{id}/return', [BorrowController::class, 'returnBorrow'])->name('borrows.return');
    Route::post('/admin/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('admin.users.reset-password');
});

Route::middleware(['operator'])->group(function () {
    // route yang hanya bisa diakses oleh operator
    Route::resource('/operator/rooms', RoomController::class)->only(['index', 'show']);
    Route::resource('/operator/items', ItemController::class);
    Route::resource('/operator/borrows', BorrowController::class);
    Route::put('/operator/borrows/{id}/return', [BorrowController::class, 'returnBorrow'])->name('borrows.return');
});

Route::middleware('borrower')->group(function () {
    // route yang hanya bisa diakses oleh borrower
    // Route::get('/borrower/dashboard', 'BorrowerController@dashboard');
    Route::resource('/borrower/borrows', BorrowController::class);
});
Route::middleware('AdminOrOperator')->group(function () {
    // route yang hanya bisa diakses oleh borrower
    // Route::get('/borrower/dashboard', 'BorrowerController@dashboard');
    Route::resource('borrows', BorrowController::class);
});
Route::middleware('AdminOrOperator')->group(function () {
    // route yang hanya bisa diakses oleh borrower
    // Route::get('/borrower/dashboard', 'BorrowerController@dashboard');
    Route::resource('borrows', BorrowController::class);
});
Route::middleware('auth')->group(function () {
    // route yang hanya bisa diakses oleh borrower
    // Route::get('/borrower/dashboard', 'BorrowerController@dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});




Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');