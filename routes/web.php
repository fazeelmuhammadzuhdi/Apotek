<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\OpnameController;
use App\Http\Controllers\PembayaranController;
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

Route::group(['middleware' => ['role:kasir|owner|gudang']], function () {
    Route::get('stock-index', [StockObatController::class, 'index'])->name('stock.index');

    Route::get('penjualan-index', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('penjualan-store', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('penjualan-data', [PenjualanController::class, 'data'])->name('penjualan.data');
    Route::post('penjualan-hapus', [PenjualanController::class, 'hapus'])->name('penjualan.hapus');
});

Route::group(['middleware' => ['role:owner|gudang']], function () {
    Route::get('obat-index', [ObatController::class, 'index'])->name('obat.index');
    Route::post('obat-store', [ObatController::class, 'store'])->name('obat.store');
    Route::post('obat-edit', [ObatController::class, 'edit'])->name('obat.edit');
    Route::post('obat-update', [ObatController::class, 'update'])->name('obat.update');
    Route::post('obat-hapus', [ObatController::class, 'destroy'])->name('obat.hapus');

    Route::post('stock-store', [StockObatController::class, 'store'])->name('stock.store');
    Route::post('stock-hapus', [StockObatController::class, 'hapus'])->name('stock.hapus');
    Route::post('stock-edit', [StockObatController::class, 'edit'])->name('stock.edit');
    Route::post('stock-update', [StockObatController::class, 'update'])->name('stock.update');

    Route::get('opname', [OpnameController::class, 'index'])->name('opname-index');
    Route::post('opname-store', [OpnameController::class, 'store'])->name('opname-store');
    Route::get('opname-databelanja', [OpnameController::class, 'databelanja'])->name('opname-databelanja');
    Route::get('opname-datajual', [OpnameController::class, 'datajual'])->name('opname-datajual');
    Route::post('opname-cekstock', [OpnameController::class, 'cekStock'])->name('opname-cekstock');
});


Route::group(['middleware' => ['role:owner']], function () {
    Route::get('supplier-index', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('supplier-store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::post('supplier-edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::post('supplier-update', [SupplierController::class, 'update'])->name('supplier.update');
    Route::post('supplier-hapus', [SupplierController::class, 'destroy'])->name('supplier.hapus');

    Route::get('pembelian-index', [PembelianController::class, 'index'])->name('pembelian.index');
    Route::post('pembelian-store', [PembelianController::class, 'store'])->name('pembelian.store');
    Route::post('pembelian-hapus', [PembelianController::class, 'hapus'])->name('pembelian.hapus');
    Route::post('pembelian-bayar', [PembelianController::class, 'bayar'])->name('pembelian.bayar');

    Route::post('pembayaran-store', [PembayaranController::class, 'store'])->name('pembayaran.store');

    Route::get('laporan-index', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('pembayaran-datatablejual', [LaporanController::class, 'dataTablePenjualan'])->name('dataTablePenjualan');
    Route::get('pembayaran-datatablebeli', [LaporanController::class, 'dataTablePembelian'])->name('dataTableBelanja');
});

require __DIR__ . '/auth.php';
