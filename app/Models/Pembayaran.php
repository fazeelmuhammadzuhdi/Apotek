<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'pembayarans';
    protected $fillable = [
        'nota',
        'total',
        'diskon',
        'pajak',
        'dibayar',
        'kembali',
        'status',
    ];

    public static function joinbeli()
    {
        return $data = DB::table('pembayarans')
            ->join('pembelians', 'pembayarans.nota', '=', 'pembelians.faktur')
            ->join('suppliers', 'pembelians.supplier', '=', 'suppliers.id')
            ->join('users', 'pembelians.admin', '=', 'users.id')
            ->select('pembayarans.*', 'suppliers.nama as suppliers', 'users.name', 'pembelians.qty as qtys', 'pembelians.item as items');
    }

    public static function joinjual()
    {
        return $data = DB::table('pembayarans')
            ->join('penjualans', 'pembayarans.nota', '=', 'penjualans.nota')
            ->join('obats', 'obats.id', '=', 'penjualans.item')
            ->join('stock_obats', 'stock_obats.IdObat', '=', 'obats.id')
            ->join('pasiens', 'penjualans.consumer', '=', 'pasiens.id')
            ->join('users', 'penjualans.kasir', '=', 'users.id')
            ->select(
                'penjualans.id as idPenjualan',
                'penjualans.qty as Qty',
                'penjualans.subtotal as hargaperobat',
                'obats.nama as namaObat',
                'obats.satuan',
                'pasiens.nama as customer',
                'users.name',
                'stock_obats.jual',
                'pembayarans.*',
            );
    }
}
