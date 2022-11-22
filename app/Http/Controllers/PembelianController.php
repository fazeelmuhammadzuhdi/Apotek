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

    public function dataTable(Request $request)
    {
        $faktur = $request->faktur;
        $data = Pembelian::join()
            ->where('pembelians.faktur', $faktur)
            ->select('pembelians.*', 'suppliers.nama as suppliers')
            ->latest();

        if (request()->ajax()) {
            if (!empty($faktur)) {
                return datatables()->of($data)
                    ->addColumn('aksi', function ($data) {
                        $button = ' <button class="hapus btn btn-sm btn-danger" id="' . $data->id . '" name="hapus">Hapus</button> ';
                        return $button;
                    })
                    ->rawColumns(['aksi'])
                    ->make(true);
            }
        }
    }

    public function hapus(Request $request)
    {
        $id = $request->id;
        $data = Pembelian::find($id);
        $hapus = $data->delete();

        if ($hapus) {
            return response()->json(['text' => 'Data Berhasil Di Hapus '], 200);
        } else {
            return response()->json(['text' => 'Gagal Di Hapus'], 400);
        }
    }

    public function bayar(Request $request)
    {
        $faktur = $request->id;
        $data = Pembelian::hitung($faktur)
            ->groupBy('faktur')
            ->get();

        return response()->json(['data' => $data], 200);
    }
}
