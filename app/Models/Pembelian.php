<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
