<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
