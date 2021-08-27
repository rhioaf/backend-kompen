<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'card';
    protected $primaryKey = 'id_cart';
    public $timestamps = false;

    protected $fillable = [
        'id_produk',
        'harga_produk',
        'total_pesan'
    ];
}
