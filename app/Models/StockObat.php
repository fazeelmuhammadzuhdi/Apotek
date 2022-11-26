<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StockObat extends Model
{
    use HasFactory;

    protected $fillable = [
        'idObat',
        'masuk',
        'keluar',
        'jual',
        'beli',
        'expired',
        'stock',
        'keterangan',
        'admin'
    ];


    public static function join()
    {
        $data = DB::table('stock_obats')->join('obats', 'obats.id', 'stock_obats.idObat')
            ->join('users', 'users.id', 'stock_obats.admin')
            ->select('stock_obats.*', 'obats.nama as namaObat', 'users.name as admins');
        return $data;
    }
}
