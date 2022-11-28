<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';
    protected $fillable = [
        'nota',
        'status',
        'tanggal',
        'qty',
        'pajak',
        'diskon',
        'subtotal',
        'item',
        'consumer',
        'kasir',
    ];

    public static function join()
    {
        return $data = DB::table('penjualans')
            ->join('obats', 'obats.id', '=', 'penjualans.item')
            ->join('pasiens', 'pasiens.id', '=', 'penjualans.consumer')
            ->join('stock_obats', 'stock_obats.idObat', '=', 'obats.id')
            ->join('users', 'users.id', '=', 'penjualans.kasir')
            ->select(
                'penjualans.*',
                'obats.nama as nama_obat',
                'users.name',
                'stock_obats.jual',
                'pasiens.nama as customer',
            );
    }

    public static function hitung($id)
    {
        $data = Penjualan::where('nota', $id)
            ->selectRaw('SUM(subtotal) as totalHarga')
            ->selectRaw('nota')
            ->groupBy('nota');

        return $data;
    }

    public static function joinCetak()
    {
        return $data = DB::table('penjualans')
            ->join('obats', 'obats.id', '=', 'penjualans.item')
            ->join('pasiens', 'pasiens.id', '=', 'penjualans.consumer')
            ->join('stock_obats', 'stock_obats.idObat', '=', 'obats.id')
            ->join('users', 'users.id', '=', 'penjualans.kasir')
            ->join('pembayarans', 'pembayarans.nota', '=', 'penjualans.nota')
            ->select(
                'penjualans.*',
                'obats.nama as nama_obat',
                'obats.indikasi',
                'obats.kode',
                'obats.dosis',
                'obats.satuan',
                'pasiens.nama as customer',
                'pasiens.alamat',
                'pasiens.telp',
                'users.name',
                'pembayarans.total',
                'pembayarans.kembali',
                'pembayarans.diskon',
                'pembayarans.dibayar',
                'stock_obats.jual',
            );
    }
}
