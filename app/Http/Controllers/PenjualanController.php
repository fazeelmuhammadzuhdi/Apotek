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
            $urut = 1000000;
            $nomer = 'NT' . $thnBulan . $urut;
        } else {
            $ambil = Penjualan::all()->last();
            $urut = (int)substr($ambil->nota, -1) + 1;
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

        $pasien = [
            'nama' => $request->nama,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'resep' => $request->resep,
            'pengirim' => $request->pengirim
        ];
        $consumer = Pasien::create($pasien);
        $idPasien = $consumer->id;
        $penjualan = [
            'nota' => $request->no,
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

    public function data(Request $request)
    {
        $no = $request->id;
        $data = Penjualan::join()
            ->where('penjualans.nota', $no)->latest();

        if (request()->ajax()) {
            return datatables()->of($data)
                ->addColumn('aksi', function ($data) {
                    $button = ' <button class="hapus btn btn-sm btn-danger" id="' . $data->id . '" name="hapus">Hapus</button> ';
                    return $button;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function hapus(Request $request)
    {
        $id = $request->id;
        $hapusJual = Penjualan::find($id);
        $stock = StockObat::where('idObat', $hapusJual->item)->first();
        $tambah = $hapusJual->qty + $stock->stock;
        $stock->update(['stock' => $tambah]);
        if ($stock) {
            $hapus = $hapusJual->delete();
            return response()->json(['text' => 'Data Berhasil Di Kurangi'], 200);
        } else {
            return response()->json(['text' => 'Sistem Error'], 400);
        }
    }

    public function hitung(Request $request)
    {
        $id = $request->id;
        $data = Penjualan::hitung($id)->get();
        $datas = Penjualan::where('nota', $id)->get();
        $discount = [];

        foreach ($datas as $key) {
            array_push($discount, ($key->diskon / 100 * $key->subtotal));
        }
        $diskon = array_sum($discount);

        return response()->json(['data' => $data, 'diskon' => $diskon], 200);
    }
}
