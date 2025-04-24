<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobCardController;
use App\Http\Controllers\JobcardDetailController;
use App\Http\Controllers\KelolaMaterialController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AutoLogout;
use Illuminate\Support\Facades\Route;

// Routes for authentication
Route::get('/', [LoginController::class, 'index'])->name('auth.login');
Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


//auto Logout
Route::middleware([AutoLogout::class])->group(function () {

    // Profile
    Route::prefix('profile')->group(function () {
        Route::get('/edit/{id}',[ProfileController::class,'index'])->name('edit');
        Route::put('/update/{id}',[ProfileController::class,'update'])->name('update');
    });

    // Admin 
    Route::group(['prefix' => 'admin', 'middleware' => ['admin'], 'as' => 'admin.'], function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard'); 

        Route::prefix('jobcard')->group(function () {
            Route::get('/', [JobCardController::class, 'index'])->name('jobcard');
            Route::get('/add', [JobCardController::class, 'add'])->name('jobcard.add');
            Route::post('/store', [JobCardController::class, 'store'])->name('jobcard.store');
            Route::get('/edit/{id}', [JobCardController::class, 'edit'])->name('jobcard.edit');
            Route::get('/show/{id}', [JobCardController::class, 'show'])->name('jobcard.show');
            Route::put('/update/{id}', [JobCardController::class, 'update'])->name('jobcard.update');
            Route::get('/print/{id}', [JobCardController::class, 'print'])->name('jobcard.print');
            Route::delete('/delete/{id}', [JobCardController::class, 'destroy'])->name('jobcard.destroy');
            Route::prefix('detail')->group(function () {
                Route::get('/add/{id}', [JobcardDetailController::class, 'add'])->name('jobcard.detail.add');
                Route::post('/store', [JobcardDetailController::class, 'store'])->name('jobcard.detail.store');
            });
            Route::get('/material/{id}', [JobCardController::class, 'material'])->name('jobcard.material');
            Route::delete('/material/delete/{id}', [JobCardController::class, 'material_delete'])->name('jobcard.material.delete');
            Route::prefix('pengadaan')->group(function () {
                Route::get('/add/{id}/{qty}/{prd}', [JobcardDetailController::class, 'addPengadaan'])->name('jobcard.pengadaan');

            });
            
        });
        

    });

    //Pegawai
    Route::group(['prefix' => 'pegawai', 'middleware' => ['pegawai'], 'as' => 'pegawai.'], function () {
        // Dashboard
        Route::get('/clear-notif', [DashboardController::class, 'clearnotif'])->name('clear-notifikasi');
        Route::get('/', [DashboardController::class, 'pegawai'])->name('dashboard'); 
        Route::prefix('kmaterial')->group(function () {
            Route::get('/',[KelolaMaterialController::class,'index'])->name('kmaterial');
            Route::post('/store',[KelolaMaterialController::class,'store'])->name('kmaterial.store');
            Route::put('/update/{id}',[KelolaMaterialController::class,'update'])->name('kmaterial.update');
            Route::delete('/destroy/{id}',[KelolaMaterialController::class,'destroy'])->name('kmaterial.destroy');
        });
    });
    Route::group(['prefix' => 'direktur', 'middleware' => ['direktur'], 'as' => 'direktur.'], function () {
        Route::get('/', [DashboardController::class, 'direktur'])->name('dashboard'); 
        Route::prefix('laporan')->group(function () {

        });
    });
    
});