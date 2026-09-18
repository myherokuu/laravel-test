<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return redirect()->route('budi95.dashboard');
})->middleware(['auth'])->name('dashboard');

// BUDI95 Dashboard Routes
Route::middleware(['auth'])->prefix('budi95')->name('budi95.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Budi95Controller::class, 'index'])->name('dashboard');
    Route::get('/recipients', [\App\Http\Controllers\Budi95Controller::class, 'recipients'])->name('recipients');
    Route::get('/transactions', [\App\Http\Controllers\Budi95Controller::class, 'transactions'])->name('transactions');
    Route::get('/reports', [\App\Http\Controllers\Budi95Controller::class, 'reports'])->name('reports');
});

require __DIR__.'/auth.php';

Route::view('/claim-form', 'claim-form');

use App\Http\Controllers\ClaimController;
Route::resource('submit-claim', ClaimController::class)->only(['index', 'store', 'update', 'destroy']);

Route::view('/claim-list', 'claim-list');

use App\Http\Controllers\UserTableController;
Route::get('/form', [UserTableController::class, 'index'])->name('form.index');

Route::view('/senarai-langkah', 'senarai-langkah');
