<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pembelian;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
}
