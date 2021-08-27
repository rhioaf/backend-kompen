<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Produk extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id_produk'     =>  $this->id_produk,
            'id_menu'       =>  $this->id_menu,
            'nama_produk'   =>  $this->nama_produk,
            'harga_produk'  =>  $this->harga_produk,
            'stok_produk'   =>  $this->stok_produk,
            'foto_produk'   =>  $this->foto_produk
        ];
    }
}
