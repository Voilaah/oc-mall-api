<?php

namespace Voilaah\MallApi\Models;

use Model;
use Illuminate\Http\Resources\Json\Resource;

Class CartProductResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                    => $this->id,
            'cart_id'               => $this->cart_id,
            'product_id'            => $this->product_id,
            'variant_id'            => $this->variant_id,
            'quantity'              => (int)$this->quantity,
            'weight'                => (int)$this->weight,
            'price'                 => $this->price,
            'created_at'            => (int)$this->created_at->timestamp,
            'updated_at'            => (int)$this->updated_at->timestamp,
        ];
    }
}
