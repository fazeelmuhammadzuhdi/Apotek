<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StockObatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('getObat', [StockObatController::class, 'getObat'])->name('get.obat');
Route::post('getDataObat', [StockObatController::class, 'getDataObat'])->name('getdata.obat');
Route::post('hitung', [PenjualanController::class, 'hitung'])->name('hitung');
Route::post('carikode', [ObatController::class, 'getKode'])->name('carikode');
Route::get('dataTable', [PembelianController::class, 'dataTable'])->name('data.table');
Route::post('detailjual', [LaporanController::class, 'detailJual'])->name('detail-jual');
Route::post('detailbeli', [LaporanController::class, 'detailBeli'])->name('detail-beli');
