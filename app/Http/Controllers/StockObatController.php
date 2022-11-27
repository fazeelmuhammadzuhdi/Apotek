<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\StockObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockObatController extends Controller
{
    public function index()
    {
        $obat = Obat::where('ready', 'N')->get();
        $stock = StockObat::join();
        // return response()->json($data);
        if (request()->ajax()) {
            return datatables()->of($stock)
                ->addColumn('aksi', function ($stock) {
                    if (Auth::user()->hasRole('kasir')) {
                        $button = '';
                    } else if (Auth::user()->hasRole('gudang')) {
                        $button = ' <button class="edit btn btn-sm btn-primary" id="' . $stock->id . '" name="edit">Edit</button> ';
                    } else {
                        $button = ' <button class="edit btn btn-sm btn-warning" id="' . $stock->id . '" name="edit">Edit</button> ';
                        $button .= ' <button class="hapus btn btn-sm btn-danger" id="' . $stock->id . '" name="hapus">Hapus</button> ';
                    }

                    return $button;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        return view('owner.stock-obat', compact('obat'));
    }

    public function store(Request $request)
    {
        //   dd($request->all());
        $data = new StockObat();
        $data->idObat = $request->obat;
        $data->masuk  = $request->masuk;
        $data->keluar = $request->keluar;
        $data->jual  = $request->jual;
        $data->beli = $request->beli;
        $data->expired = $request->expired;
        $data->stock = $request->stock;
        $data->keterangan = $request->keterangan;
        $data->admin = Auth::user()->id;

        $simpan = $data->save();

        if ($simpan) {
            DB::table('obats')->where('id', $request->obat)->update(['ready' => 'Y']);
            return response()->json(['text' => 'Data Berhasil Di Simpan'], 200);
        } else {
            return response()->json(['text' => 'Data Gagal Di Simpan'], 400);
        }
    }

    public function getObat(Request $request)
    {
        $data = StockObat::where('idObat', $request->id)->first();
        $null = [
            'stock' => 0
        ];

        if ($data != null) {
            return response()->json(['data' => $data]);
        } else {
            return response()->json(['data' => $null]);
        }
    }

    private function data(array  $data)
    {
        $data = [
            'idObat' => $data['obat'],
            'masuk' => $data['masuk'],
            'keluar' => $data['keluar'],
            'jual' => $data['jual'],
            'beli' => $data['beli'],
            'expired' => $data['expired'],
            'stock' => $data['stock'],
            'keterangan' => $data['keterangan'],
            'admin' => Auth::user()->id,
        ];
        return $data;
    }

    public function getDataObat(Request $request)
    {
        $data = StockObat::where('idObat', $request->id)->first();
        return response()->json($data);
    }

    public function edit(Request $request)
    {
        // $id = $request->id;
        // $data = StockObat::find($id);

        $id = $request->id;
        $data = StockObat::join($id)->where('stock_obats.id', $id)->first();

        return response()->json($data);
    }

    public function update(Request $request)
    {
        $datas = [
            'masuk' => $request->masuk,
            'keluar' => $request->keluar,
            'jual' => $request->jual,
            'beli' => $request->beli,
            'expired' => $request->expired,
            'stock' => $request->stock,
            'keterangan' => $request->keterangan,
            'admin' => Auth::user()->id,
        ];
        $data = StockObat::find($request->id);
        $simpan = $data->update($datas);

        if ($simpan) {
            return response()->json(['text' => 'Data Berhasil Di Update'], 200);
        } else {
            return response()->json(['text' => 'Data Gagal Di Update'], 400);
        }
    }

    public function hapus(Request $request)
    {
        $data = StockObat::find($request->id);
        $simpan = $data->delete();

        if ($simpan) {
            return response()->json(['text' => 'Data Berhasil Di Hapus'], 200);
        } else {
            return response()->json(['text' => 'Data Gagal Di Hapus'], 400);
        }
    }
}
