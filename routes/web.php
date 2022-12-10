<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DasborController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\HafalanController;
use App\Http\Controllers\PenggunaController;

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

Route::prefix('auth')->group(function(){
    Route::get('/login',function() {
        return view('Authentication.Login');
    }); 
    Route::post('/login',[AuthController::class, 'login']); 
    Route::get('/signout',[AuthController::class, 'logout'])->middleware('auth');
});

Route::get('/pengumuman/{Oid}/{Type?}',[PengaturanController::class, 'getPengumuman']);
Route::get('/galeri/{Oid}/{Type?}',[PengaturanController::class, 'getGaleri']);

Route::middleware(['auth'])->group(function () {
    Route::get('/',[DasborController::class, 'index']);

    Route::prefix('/setting')->group(function() {
        Route::get('/',[PengaturanController::class, 'index']);
        Route::post('/',[PengaturanController::class, 'save']);

        Route::get('/pengumuman',[PengaturanController::class, 'listPengumuman']);
        Route::get('/pengumuman/hapus/{Oid}',[PengaturanController::class, 'deletePengumuman']);
        Route::post('/pengumuman/{Oid?}',[PengaturanController::class, 'savePengumuman']);

        Route::get('/galeri',[PengaturanController::class, 'listGaleri']);
        Route::get('/galeri/hapus/{Oid}',[PengaturanController::class, 'deleteGaleri']);
        Route::post('/galeri/{Oid?}',[PengaturanController::class, 'saveGaleri']);
    });

    Route::get('/profile',[ProfilController::class, 'index']);
    Route::post('/profile',[ProfilController::class, 'save']);

    Route::prefix('/santri')->group(function() {
        Route::get('/',[SantriController::class, 'index']);
        Route::get('/tambah',[SantriController::class, 'form']);
        Route::post('/tambah',[SantriController::class, 'save']);
        Route::get('/ekspor',[SantriController::class, 'export']);
        Route::get('/ubah/{Oid}',[SantriController::class, 'form']);
        Route::post('/ubah/{Oid}',[SantriController::class, 'save']);
        Route::get('/hapus/{Oid}',[SantriController::class, 'delete']);
        Route::get('/detail/{Oid}',[SantriController::class, 'show']);
        
        Route::prefix('/tagihan')->group(function(){
            Route::get('/',[TagihanController::class, 'index']);
            Route::post('/mass',[TagihanController::class, 'createMass']);
            Route::post('/spp',[TagihanController::class, 'updateSpp']);

            Route::prefix('/excel')->group(function(){
                Route::get('/',[TagihanController::class, 'exportExcel']);
                Route::get('/{Santri}/{Type}',[TagihanController::class, 'exportExcelBySantri']);    
            });

            Route::prefix('/pdf')->group(function(){
                Route::get('/',[TagihanController::class, 'exportPdf']);
                Route::get('/{Santri}/{Type}',[TagihanController::class, 'exportPdfBySantri']);    
            });

            Route::get('/{Santri}',[TagihanController::class, 'show']);
            Route::get('/{Santri}/{Oid}/delete',[TagihanController::class, 'delete']);
            Route::get('/{Santri}/{Oid}/pay',[TagihanController::class, 'pay']);
            Route::get('/{Santri}/{Oid}',[TagihanController::class, 'update']);
            Route::post('/{Santri}/{Oid?}',[TagihanController::class, 'save']);
        });

        Route::prefix('/hafalan')->group(function(){
            Route::get('/',[HafalanController::class, 'index']);
            Route::get('/{Santri}/{Oid?}/delete',[HafalanController::class, 'delete']);
            Route::get('/{Santri}',[HafalanController::class, 'show']);
            Route::post('/{Santri}/{Oid?}',[HafalanController::class, 'save']);
        });
    });

    Route::prefix('/pengguna')->group(function(){
        Route::get('/',[PenggunaController::class, 'index']);
        Route::get('/hapus/{Oid}',[PenggunaController::class, 'delete']);
        Route::get('/ubah/{Oid}',[PenggunaController::class, 'edit']);
        Route::get('/wali/{Oid?}',[PenggunaController::class, 'wali']);
        Route::post('/wali/{Oid?}',[PenggunaController::class, 'waliSave']);
        Route::post('/admin/{Oid?}',[PenggunaController::class, 'adminSave']);
    });
});