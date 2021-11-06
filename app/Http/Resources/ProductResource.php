<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'sku' => $this->sku,
            'nama_product' => $this->nama_product,
            'harga' => $this->harga,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function withResponse($request, $response)
    {
        $response->header('X-Value', 'True');
    }
}
