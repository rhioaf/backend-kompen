<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Load models
use App\Models\Produk;
use App\Http\Resources\Produk as ProdukResource;

class ProdukController extends Controller
{
    public function index($id_menu)
    {
        // Return list of produk
        $result = Produk::where('id_menu', '=', $id_menu)->get();
        return $this->sendResponse(ProdukResource::collection($result));
    }
    
    public function show($id)
    {
        //
    }
}
