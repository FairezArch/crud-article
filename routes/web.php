<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;

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
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/tologin', [AuthController::class, 'login'])->name('tologin');

Route::get('forget-password', [AuthController::class, 'showForm'])->name('forget.password');

Route::post('forget-password', [AuthController::class, 'storeForm'])->name('forget.password.store');

Route::get('reset-password/{token}', [AuthController::class, 'ShowFormReset'])->name('reset.password');

Route::post('reset-password', [AuthController::class, 'storeFormReset'])->name('reset.password.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('article', [ArticleController::class, 'index'])->name('article.index');

    Route::group(['middleware' => ['role:author|visitor']], function () {
        Route::get('article/{article}', [ArticleController::class, 'show'])->name('article.show');
    });

    Route::group(['middleware' => ['role:author']], function () {
        Route::post('article', [ArticleController::class, 'store'])->name('article.store');
        Route::get('article/{article}/edit', [ArticleController::class, 'edit'])->name('article.edit');
        Route::put('article/{article}', [ArticleController::class, 'update'])->name('article.update');
        Route::delete('article/{article}', [ArticleController::class, 'destroy'])->name('article.destroy');
    });
});
