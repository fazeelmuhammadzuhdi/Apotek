<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index()
    {
        $data = Supplier::all();
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
        return view('owner.supplier-home');
    }

    public function store(Request $request)
    {

        $rules = [
            'nama' => 'required',
            'telp' => 'required|min:12|unique:suppliers,telp',
            'email' => 'required|unique:suppliers,email',
            'rekening' => 'required|unique:suppliers,rekening',
            'alamat' => 'required',
        ];

        $text = [
            'nama.required' => 'Kolom Nama Tidak Boleh Kosong',
            'telp.required' => 'Kolom Telepon Tidak Boleh Kosong',
            'telp.unique' => 'No Telepon Sudah Terdaftar',
            'telp.min' => 'Inputkan Kurang dari 12',
            'email.required' => 'Kolom Email Tidak Boleh Kosong',
            'email.unique' => 'Email Sudah Terdaftar',
            'alamat.required' => 'Kolom Alamat Tidak Boleh Kosong',
            'rekening.required' => 'Kolom Rekening Tidak Boleh Kosong',
            'rekening.unique' => 'No Rekening Sudah Terdaftar',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);

        if ($validasi->fails()) {
            return response()->json(['success' => 0, 'text' => $validasi->errors()->first()], 400);
        }
        // dd($request->all());
        $simpan = Supplier::create($request->all());

        if ($simpan) {
            return response()->json(['text' => 'Data Berhasil Di Simpan'], 200);
        } else {
            return response()->json(['text' => 'Data Gagal Di Simpan'], 400);
        }
    }

    public function edit(Request $request)
    {
        // dd($request->all());
        $data = Supplier::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $data = Supplier::find($request->id);
        $simpan = $data->update($request->all());

        if ($simpan) {
            return response()->json(['text' => 'Data Berhasil Di Update'], 200);
        } else {
            return response()->json(['text' => 'Data Gagal Di Update'], 400);
        }
    }

    public function destroy(Request $request)
    {
        $data = Supplier::find($request->id);
        $simpan = $data->delete($request->all());

        if ($simpan) {
            return response()->json(['text' => 'Data Berhasil Di Hapus'], 200);
        } else {
            return response()->json(['text' => 'Data Gagal Di Hapus'], 400);
        }
    }
}
