<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelians';
    protected $fillable = [
        'faktur',
        'item',
        'harga',
        'qty',
        'tanggal',
        'totalkotor',
        'pajak',
        'diskon',
        'totalbersih',
        'keterangan',
        'supplier',
        'admin'
    ];

    public static function join()
    {
        return DB::table('pembelians')
            ->join('suppliers', 'suppliers.id', '=', 'pembelians.supplier')
            ->join('users', 'users.id', '=', 'pembelians.admin');
    }

    public static function hitung(String $id)
    {
        return DB::table('pembelians')
            ->where('faktur', $id)
            // ->select('*')
            ->selectRaw('SUM(totalkotor) as total_kotor')
            ->selectRaw('SUM(pajak) as pajaks')
            ->selectRaw('SUM(totalbersih) as total_bersih')
            ->selectRaw('SUM(diskon) as diskons');
    }
}
