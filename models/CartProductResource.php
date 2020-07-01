<?php

namespace Voilaah\MallApi\Models;

use OFFLINE\Mall\Models\Currency;
use OFFLINE\Mall\Classes\Utils\Money;
use Voilaah\MallApi\Models\ImageResource;

Class CartProductResource extends SimpleApiResource
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
            // 'id'                    => $this->id,
            'id'                    => $this->hashId,
            'cart_id'               => $this->cart_id,
            'product_id'            => $this->product_id,
            'product_slug'          => $this->product->slug,
            'variant_id'            => $this->variant_id,
            'variant_slug'          => $this->variant->hashId,
            "url"                   => route('products.show', ['recordId' =>  $this->product->slug . '/' . $this->variant->hashId] ),
            'quantity'              => (int)$this->quantity,
            'weight'                => (int)$this->weight,
            // 'item_data'             => $this->item_data,
            'unit_price'            => $this->price,
            'unit_price_raw'        => $this->price()->integer,
            'unit_price_formatted'  => (string)$this->price(),
            // 'total_pre_taxes'       => $this->total_pre_taxes,
            // 'total_taxes'           => $this->total_taxes,
            'total_post_taxes_raw'      => $this->total_post_taxes,
            'total_post_taxes_formatted'=> app(Money::class)->format($this->total_post_taxes),
            // 'price_total'           => $this->price(),
            'image'                 => ImageResource::make($this->variant->image),
            'created_at'            => (int)$this->created_at->timestamp,
            'updated_at'            => (int)$this->updated_at->timestamp,
        ];
    }

    public function with($request)
    {
        // $with = : parent::with($request);
        return [
            'meta' => [
                'currency'              => optional(Currency::activeCurrency())->only('symbol', 'code', 'rate', 'decimals'),
            ]
        ];
    }


    public function getResourceName()
    {
        return "cart_item";
    }


}
