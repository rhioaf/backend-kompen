<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $primaryKey = 'id_product';
    public $timestamps = false;

    protected $fillable = [
        'nama_produk',
        'harga_produk',
        'stok_produk',
        'foto_produk'
    ];
}
