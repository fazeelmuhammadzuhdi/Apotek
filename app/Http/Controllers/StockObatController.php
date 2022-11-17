<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\StockObat;
use Illuminate\Http\Request;

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
                    $button = ' <button class="edit btn btn-sm btn-warning" id="' . $stock->id . '" name="edit">Edit</button> ';
                    $button .= ' <button class="hapus btn btn-sm btn-danger" id="' . $stock->id . '" name="hapus">Hapus</button> ';
                    return $button;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        return view('owner.stock-obat', compact('obat'));
    }

    public function store(Request $request)
    {
        dd($request->all());
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
}
