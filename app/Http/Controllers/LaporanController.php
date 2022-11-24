<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('owner.laporan');
    }

    public function dataTablePenjualan()
    {
        $data = Penjualan::join()
            ->groupBy('penjualans.nota')
            ->selectRaw('SUM(penjualans.subtotal) as totals')
            ->selectRaw('SUM(penjualans.diskon) as diskons')
            ->get();
        if (request()->ajax()) {
            return datatables()->of($data)
                ->addColumn('aksi', function ($data) {
                    $button = ' <button class="detail btn btn-sm btn-info" id="' . $data->id . '" name="detail">Detail</button> ';
                    return $button;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function dataTablePembelian()
    {
        $data = Pembelian::join()
            ->groupBy('pembelians.faktur')
            ->select('pembelians.*', 'suppliers.nama as suppliers', 'users.name')
            ->selectRaw('SUM(pembelians.totalbersih) as totals')
            ->get();
        if (request()->ajax()) {
            return datatables()->of($data)
                ->addColumn('aksi', function ($data) {
                    $button = ' <button class="detail btn btn-sm btn-info" id="' . $data->id . '" name="detail">Detail</button> ';
                    return $button;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }
}
