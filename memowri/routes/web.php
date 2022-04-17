<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AddcategoryController;
use App\Http\Controllers\AddnoteController;
use App\Http\Controllers\BackgroundController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditaccountController;
use App\Http\Controllers\EditcategoryController;
use App\Http\Controllers\EditnoteController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;

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

//index.show


Route::get('/login', function () {
    return session()->has('user') ? redirect('/') : view('login');
})->name("login.show");


Route::name('user.')->group(function () {
    Route::post('/login', [LoginController::class, 'show'])->name('login');
    Route::get('/signup', function () {
        return session()->has('user') ? redirect('/') : view('signup');
    })->name("create");

    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::post("/signup", [SignupController::class, 'store'])->name('store');
    Route::get("/settings", [EditaccountController::class, 'edit'])->name('edit');
    Route::patch("/settings/update", [EditaccountController::class, 'update'])->name('update');

    Route::get('/logout', function(){
        if(session()->has('user'))
            session()->flush();
        return redirect('login');
    })->name('logout');
});

Route::prefix("note")->name("note.")->group(function () {
    Route::get("/create", [AddnoteController::class, 'create'])->name('create');
    Route::post("/", [AddnoteController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [EditnoteController::class, 'edit'])->name('edit');
    Route::patch('/{id}/update', [EditnoteController::class, 'update'])->name('update');
    Route::patch('/{id}/updateorder', [DashboardController::class, 'update'])->name('updateorder');
    Route::delete('/{id}/delete', [DashboardController::class, 'destroyNote'])->name('destroy');
});

Route::prefix("category")->name("category.")->group(function () {
    Route::get("/create", [AddcategoryController::class, 'index'])->name('create');
    Route::post("/", [AddcategoryController::class, 'store'])->name('store');
    Route::get("/{id}/edit", [EditcategoryController::class, 'edit'])->name('edit');
    Route::patch("/{id}/update", [EditcategoryController::class, 'update'])->name('update');
    Route::delete('/{id}/delete', [DashboardController::class, 'destroyCategory'])->name('destroy');
});

Route::prefix("background")->name('background.')->group(function(){
    Route::get("/", [BackgroundController::class, 'edit'])->name('edit');
    Route::patch("/update", [BackgroundController::class, 'update'])->name('update');
});

Route::get('/backgrounds/{filename}', [FileController::class, 'images']);



