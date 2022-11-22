<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StockObatController;
use App\Http\Controllers\SupplierController;
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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::group(['middleware' => ['role:owner']], function () {
    Route::get('supplier-index', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('supplier-store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::post('supplier-edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::post('supplier-update', [SupplierController::class, 'update'])->name('supplier.update');
    Route::post('supplier-hapus', [SupplierController::class, 'destroy'])->name('supplier.hapus');


    Route::get('obat-index', [ObatController::class, 'index'])->name('obat.index');
    Route::post('obat-store', [ObatController::class, 'store'])->name('obat.store');
    Route::post('obat-edit', [ObatController::class, 'edit'])->name('obat.edit');
    Route::post('obat-update', [ObatController::class, 'update'])->name('obat.update');
    Route::post('obat-hapus', [ObatController::class, 'destroy'])->name('obat.hapus');

    Route::get('stock-index', [StockObatController::class, 'index'])->name('stock.index');
    Route::post('stock-store', [StockObatController::class, 'store'])->name('stock.store');


    Route::get('penjualan-index', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('penjualan-store', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('penjualan-data', [PenjualanController::class, 'data'])->name('penjualan.data');
    Route::post('penjualan-hapus', [PenjualanController::class, 'hapus'])->name('penjualan.hapus');

    Route::get('pembelian-index', [PembelianController::class, 'index'])->name('pembelian.index');
    Route::post('pembelian-store', [PembelianController::class, 'store'])->name('pembelian.store');
    Route::post('pembelian-hapus', [PembelianController::class, 'hapus'])->name('pembelian.hapus');
});

require __DIR__ . '/auth.php';
