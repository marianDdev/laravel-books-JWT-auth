<?php

use App\Http\Controllers\BooksController;
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

Route::group(['middleware' => 'auth'], function () {    {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        /** Books web routes */
        Route::get('/books', [BooksController::class, 'index'])->name('books');
        Route::get('/books/create', [BooksController::class, 'create'])->name('add_book');
        Route::post('/books', [BooksController::class, 'store']);
        Route::delete('/books/{bookId}', [BooksController::class, 'destroy'])->name('delete_book');
    }
});
require __DIR__.'/auth.php';

