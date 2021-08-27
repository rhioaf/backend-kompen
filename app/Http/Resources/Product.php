<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'id_product'    =>  $this->id_product,
            'nama_product'  =>  $this->nama_product,
            'harga_product' =>  $this->harga_product,
            'stok_product'  =>  $this->stok_product,
            'foto_product'  =>  $this->foto_product
        ];
    }
}
