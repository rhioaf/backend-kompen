<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Http\Resources\Product as ProductResource;

class ProductController extends Controller
{
    // Return list of Menu
    public function all(){
        $result = Product::all();
        return $this->sendResponse(ProductResource::collection($result));
    }

    public function detail($id)
    {
        $result = Product::where('id_product', $id)->first();
        if(is_null($result)){
            return $this->sendError('Produk tidak ditemukan');
        }
        return $this->sendResponse($result);
    }
}
