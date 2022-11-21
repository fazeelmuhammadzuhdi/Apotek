<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Obat;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ObatController extends Controller
{
    public function index()
    {
        $satuan = Satuan::select('id', 'satuan')->get();
        $kategori = Kategori::select('id', 'kategori')->get();

        $data = Obat::join();
        // return response()->json($data);
        if (request()->ajax()) {
            return datatables()->of($data)
                ->addColumn('aksi', function ($data) {
                    $button = ' <button class="edit btn btn-sm btn-warning" id="' . $data->id . '" name="edit">Edit</button> ';
                    $button .= ' <button class="hapus btn btn-sm btn-danger" id="' . $data->id . '" name="hapus">Hapus</button> ';
                    return $button;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        return view('owner.obat-home', compact('satuan', 'kategori'));
    }

    public function store(Request $request)
    {

        $rules = [
            'nama' => 'required',
            'kode' => 'required|max:8|unique:obats,kode',
            'dosis' => 'required',
            'indikasi' => 'required',
        ];

        $text = [
            'nama.required' => 'Kolom Nama Tidak Boleh Kosong',
            'kode.required' => 'Kolom Kode Tidak Boleh Kosong',
            'kode.unique' => 'No Kode Sudah Terdaftar',
            'kode.max' => 'Inputkan 8 Karakter',
            'indikasi.required' => 'Kolom Indikasi Tidak Boleh Kosong',

        ];

        $validasi = Validator::make($request->all(), $rules, $text);

        if ($validasi->fails()) {
            return response()->json(['success' => 0, 'text' => $validasi->errors()->first()], 400);
        }
        // dd($request->all());
        $simpan = Obat::create($request->all());

        if ($simpan) {
            return response()->json(['text' => 'Data Berhasil Di Simpan'], 200);
        } else {
            return response()->json(['text' => 'Data Gagal Di Simpan'], 400);
        }
    }

    public function edit(Request $request)
    {
        // dd($request->all());
        $data = Obat::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $data = Obat::find($request->id);
        $simpan = $data->update($request->all());

        if ($simpan) {
            return response()->json(['text' => 'Data Berhasil Di Update'], 200);
        } else {
            return response()->json(['text' => 'Data Gagal Di Update'], 400);
        }
    }

    public function destroy(Request $request)
    {
        $data = Obat::find($request->id);
        $simpan = $data->delete($request->all());

        if ($simpan) {
            return response()->json(['text' => 'Data Berhasil Di Hapus'], 200);
        } else {
            return response()->json(['text' => 'Data Gagal Di Hapus'], 400);
        }
    }

    public function getKode(Request $request)
    {
        $kode = $request->kode;
        $data = Obat::where('id', $kode)->get();

        return response()->json($data, 200);
    }
}
