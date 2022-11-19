<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'kode', 'dosis', 'indikasi', 'kategori', 'satuan'
    ];

    public static function join()
    {
        $data = DB::table('obats')->join('kategoris', 'obats.kategori', 'kategoris.id')
            ->join('satuans', 'obats.satuan', 'satuans.id')
            ->select('obats.*', 'satuans.satuan as satuans', 'kategoris.kategori as kategoris')
            ->get();
        return $data;
    }

    public static function joinStock()
    {
        $data = DB::table('stock_obats')->join('obats', 'obats.id', 'stock_obats.idObat')
            ->select('stock_obats.*', 'obats.nama as namaObat', 'obats.id as idObat')
            ->get();
        return $data;
    }
}
