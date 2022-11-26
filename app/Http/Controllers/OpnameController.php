<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pembayaran;
use App\Models\Penjualan;
use App\Models\StockObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpnameController extends Controller
{
    public function index()
    {
        $obat = Obat::all();
        return view('owner.opname', compact('obat'));;
    }

    public function store(Request $request)
    {

        $data = [
            'idObat' => $request->obat,
            'stock' => $request->real,
            'keterangan' => 'Telah Di Opname Oleh ' . Auth::user()->name . '.', 'Dengan Alasan : ' . $request->keterangan
        ];

        $stock = StockObat::where('idObat', $request->obat)->first();
        $opname = $stock->update($data);

        if ($opname) {
            return response()->json(['text' => 'Data Berhasil Di Ubah'], 200);
        } else {
            return response()->json(['text' => 'Gagal'], 400);
        }
    }

    public function databelanja(Request $request)
    {
        $obat = Obat::find($request->id);
        if ($obat != null) {
            $beli = Pembayaran::joinbeli()->where('pembelians.item', $obat->nama)->get();
        } else {
            $beli = [];
        }

        if (request()->ajax()) {
            return datatables()->of($beli)->make(true);
        }
    }
    public function datajual(Request $request)
    {
        $jual = Penjualan::join()->where('penjualans.item', $request->id)->get();
        if (request()->ajax()) {
            return datatables()->of($jual)->make(true);
        }
    }

    public function cekStock(Request $request)
    {
        $stock = StockObat::where('idObat', $request->id)->get();
        return response()->json(['stock' => $stock]);
    }
}
