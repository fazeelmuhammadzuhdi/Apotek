<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pembelian;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PembelianController extends Controller
{
    public function index()
    {
        $supp = Supplier::pluck('nama', 'id');
        $kode = Obat::select('id', 'kode')->get();
        $time = Carbon::now()->format('Y-m-d');
        $mytime = Carbon::now();
        $tanggal = $mytime->year . $mytime->month;
        $hitung = Pembelian::count();

        if ($hitung == 0) {
            $urut = 100001;
            $nomer = 'FKTR' . $tanggal . $urut;
        } else {
            $ambil = Pembelian::all()->last();
            $urut = (int)substr($ambil->faktur, -6) + 1;
            $nomer = 'FKTR' . $tanggal . $urut;
        }
        return view('owner.pembelian', compact('time', 'nomer', 'supp', 'kode'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $discount = ((int)$request->diskon / 100) * $request->subtotal;
        $pajakk = ((int)$request->pajak / 100) * $request->subtotal;
        $bersih = ((int)$request->subtotal + $pajakk) - $discount;
        $data = [
            'faktur' => $request->faktur,
            'item' => $request->item,
            'harga' => $request->harga,
            'qty' => $request->qty,
            'tanggal' => $request->tanggal,
            'totalkotor' => $request->subtotal,
            'pajak' => $pajakk,
            'diskon' => $discount,
            'totalbersih' => $bersih,
            'keterangan' => $request->keterangan,
            'supplier' => $request->supplier,
            'admin' => Auth::user()->id
        ];

        $simpan = Pembelian::create($data);

        if ($simpan) {
            return response()->json(['text' => 'Data Berhasil Di Simpan '], 200);
        } else {
            return response()->json(['text' => 'Gangguan System'], 400);
        }
    }
}
