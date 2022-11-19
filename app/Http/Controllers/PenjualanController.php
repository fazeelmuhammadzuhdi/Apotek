<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Penjualan;
use App\Models\StockObat;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    public function index()
    {
        $obat = Obat::joinStock();
        $tanggals = Carbon::now()->format('Y-m-d');
        $now = Carbon::now();
        $thnBulan = $now->year . $now->month;
        $cek = Penjualan::count();
        if ($cek == 0) {
            $urut = 001;
            $nomer = 'NT' . $thnBulan . $urut;
        } else {
            $ambil = Penjualan::all()->last();
            $urut = (int)substr($ambil->nota, -5) + 1;
            $nomer = 'NT' . $thnBulan . $urut;
        }
        return view('owner.penjualan', compact('obat', 'tanggals', 'nomer'));
    }

    public function store(Request $request)
    {


        $rules = [
            'nama' => 'required',
            'telp' => 'required',
            'obat' => 'required',
            'qty' => 'required',
            'alamat' => 'required',
        ];

        $text = [
            'nama.required' => 'Kolom Nama Tidak Boleh Kosong',
            'telp.required' => 'Kolom Telepon Tidak Boleh Kosong',
            'obat.required' => 'Kolom Obat Tidak Boleh Kosong',
            'qty.required' => 'Kolom qty Tidak Boleh Kosong',
            'alamat.required' => 'Kolom Alamat Tidak Boleh Kosong',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);

        if ($validasi->fails()) {
            return response()->json(['success' => 0, 'text' => $validasi->errors()->first()], 422);
        }
        dd($request->all());

        $pasien = [
            'nama' => $request->name,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'resep' => $request->resep,
            'pengirim' => $request->pengirim
        ];
        $consumer = Pasien::create($pasien);
        $idPasien = $consumer->id;

        $penjualan = [
            'nota' => $request->nota,
            'tanggal' => $request->tanggal,
            'qty' => $request->qty,
            'diskon' => $request->diskon,
            'subtotal' => $request->total,
            'item' => $request->obat,
            'consumer' => $idPasien,
            'kasir' => Auth::user()->id
        ];

        $transaksi = Penjualan::create($penjualan);
        if ($transaksi) {
            $stock = StockObat::where('idObat', $request->obat)->first();
            $stock->update(['stock' => $request->stock]);
            return response()->json(['text' => 'Pembelian Ditambahkan'], 200);
        } else {
            return response()->json(['text' => 'Pembelian Gagal '], 422);
        }
    }
}
