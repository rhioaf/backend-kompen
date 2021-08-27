<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_iten';
    public $timestamps = false;

    protected $fillable = [
        'id_cart',
        'id_product',
        'harga_product',
        'total_harga'
    ];
}
