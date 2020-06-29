<?php

namespace Voilaah\MallApi\Models;

use Model;
use Voilaah\MallApi\Behaviors\RestController;
use Voilaah\MallApi\Models\CartProductResource;

Class CartResource extends SimpleApiResource
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
            'data' => [
                'id'                    => (int)$this->id,
                'session_id'            => (string)$this->session_id,
                'customer_id'           => $this->customer_id, /* anonymous user if null */
                'shipping_address_id'    => $this->shipping_address_id,
                'billing_address_id'    => $this->billing_address_id,
                'shipping_method_id'    => $this->shipping_method_id, /* always default shipping method */
                'payment_method_id'     => $this->payment_method_id,
                'items'         => $this->when(
                                                $this->whenLoaded('products') && $this->products->count() >0,
                                                CartProductResource::collection($this->products)
                                            ),
                'created_at'            => (int)$this->created_at->timestamp,
                'updated_at'            => (int)$this->updated_at->timestamp,
            ]
        ];
    }

    public function getResourceName()
    {
        return "cart";
    }
}
