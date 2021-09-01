<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{

    public function all($id_cart){
        $cart = Cart::find($id_cart);
        if(is_null($cart)){
            return $this->sendError('Cart tidak ditemukan');
        }

        $listCartItem = DB::table('cart_item')->where('id_cart', $cart->id_cart)->get();

        $updatedTotalHarga = 0;
        foreach($listCartItem as $item){
            $updatedTotalHarga += $item->harga_product * $item->total_pesan;
        }

        $updatedCart = DB::table('cart')->where('id_cart', $cart->id_cart)->update(['total_harga'   =>  $updatedTotalHarga]);
        $cartData = array('id_cart' =>  $cart->id_cart, 'total_harga'   => $updatedTotalHarga, 'cart_item' =>  $listCartItem);
        return $this->sendResponse($cartData);
    }
    
    public function addToCart(Request $request){
        $validateInput = Validator::make($request->all(), 
        [
            'id_cart'       =>      'required',
            'id_product'    =>      'required',
            'total_pesan'   =>      'required'
        ]);

        if($validateInput->fails()){
            return $this->sendError($validateInput->errors(), 422);
        }

        // Validasi keberadaan cart pada database
        $cartData = Cart::find($request->id_cart);
        if(is_null($cartData)){
            return $this->sendError('Cart tidak ditemukan');
        }

        // Validasi keberadaan product
        $productData = Product::find($request->id_product);
        if(is_null($productData)){
            return $this->sendError('Product tidak ditemukan');
        }

        // Validasi kalo product yang dimasukkan sudah ada atau belum
        $validateProduct = DB::table('cart_item')->where([
            ['id_cart', '=', $request->id_cart],
            ['id_product', '=', $request->id_product]
        ])->first();

        if(is_null($validateProduct)){
            // Berarti barang nya baru mau dimasukkan ke cart
            $newCartItem = DB::table('cart_item')->insert([
                'id_cart'       =>  $cartData->id_cart,
                'id_product'    =>  $request->id_product,
                'harga_product' =>  $productData->harga_product,
                'total_pesan'   =>  $request->total_pesan
            ]);
            
            return $this->all($request->id_cart);
        } else {
            // Berarti barangnya udah ada
            // Tinggal update total barang yang dipesan
            if($request->total_pesan <= 0){
                $deleteCartItem = DB::table('cart_item')->where([
                    ['id_cart', '=', $cartData->id_cart],
                    ['id_product', '=', $request->id_product]
                ])->delete();
            } else {
                $updatedCartItem = DB::table('cart_item')->where([
                    ['id_cart', '=', $cartData->id_cart],
                    ['id_product', '=', $request->id_product]
                ])->update([
                    'total_pesan'   =>  $request->total_pesan
                ]);
            }

            return $this->all($cartData->id_cart);
        }
    }

    public function incTotalPesan($id_cart, $id_product){
        // Validasti keberadaan cart
        $cartData = Cart::find($id_cart);
        if(is_null($cartData)){
            return $this->sendError('Cart tidak ditemukan');
        }

        // Validasi keberadaan product
        $productData = Product::find($id_product);
        if(is_null($productData)){
            return $this->sendError('Product tidak ditemukan');
        }

        // Cek product pada cart item
        $validateProduct =  DB::table('cart_item')->where([
            ['id_cart', '=', $cartData->id_cart],
            ['id_product', '=', $productData->id_product]
        ])->first();
        if(is_null($validateProduct)){
            return $this->sendError('Product tidak ada pada cart item');
        }

        // Tambahkan total_pesan
        $updateTotalPesan = DB::table('cart_item')->where([
            ['id_cart', '=', $cartData->id_cart],
            ['id_product', '=', $productData->id_product]
        ])->increment('total_pesan');

        return $this->all($cartData->id_cart);
    }

    public function decTotalPesan($id_cart, $id_product){
        // Validasti keberadaan cart
        $cartData = Cart::find($id_cart);
        if(is_null($cartData)){
            return $this->sendError('Cart tidak ditemukan');
        }

        // Validasi keberadaan product
        $productData = Product::find($id_product);
        if(is_null($productData)){
            return $this->sendError('Product tidak ditemukan');
        }

        // Cek product pada cart item
        $productCartItem = DB::table('cart_item')->where([
            ['id_cart', '=', $cartData->id_cart],
            ['id_product', '=', $productData->id_product]
        ])->first();
        if(is_null($productCartItem)){
            return $this->sendError('Product tidak ada pada cart item');
        }
        
        // Validasi total pesan pada product
        // Kalo 1 hapus dari database else kurangin -1
        if($productCartItem->total_pesan <= 1){
            $deleteCartItem = DB::table('cart_item')->where([
                ['id_cart', '=', $cartData->id_cart],
                ['id_product', '=', $productData->id_product]
            ])->delete();
        } else {
            // Tambahkan total_pesan
            $updateTotalPesan = DB::table('cart_item')->where([
                ['id_cart', '=', $cartData->id_cart],
                ['id_product', '=', $productData->id_product]
            ])->decrement('total_pesan');
        }

        return $this->all($cartData->id_cart);
    }

    public function removeProductInCartItem($id_cart, $id_product){
        // Validasti keberadaan cart
        $cartData = Cart::find($id_cart);
        if(is_null($cartData)){
            return $this->sendError('Cart tidak ditemukan');
        }

        // Validasi keberadaan product
        $productData = Product::find($id_product);
        if(is_null($productData)){
            return $this->sendError('Product tidak ditemukan');
        }

        // Cek product pada cart item
        $productCartItem = DB::table('cart_item')->where([
            ['id_cart', '=', $cartData->id_cart],
            ['id_product', '=', $productData->id_product]
        ])->first();
        if(is_null($productCartItem)){
            return $this->sendError('Product tidak ada pada cart item');
        }

        $deleteCartItem = DB::table('cart_item')->where([
            ['id_cart', '=', $cartData->id_cart],
            ['id_product', '=', $productData->id_product]
        ])->delete();

        return $this->all($cartData->id_cart);
    }

    public function delete($id_cart){
        // Validasti keberadaan cart
        $cartData = Cart::find($id_cart);
        if(is_null($cartData)){
            return $this->sendError('Cart tidak ditemukan');
        }

        $deleteCart = DB::table('cart_item')->where('id_cart', $id_cart)->delete();
        return $this->all($id_cart);
    }
}
