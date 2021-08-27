<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    // Return list of Menu
    public function all(){
        $result = Product::all();
        return $this->sendResponse($result);
    }
}
