<?php

namespace Voilaah\MallApi\Models;

class CartTotalsResource extends SimpleApiResource
{
    public function toArray($request)
    {
       return [
            'products_total'        => $this->productPostTaxes(),
            'shipping_name'         => $this->shippingTotal()->method()->name,
            'shipping_total'        => $this->shippingTotal()->totalPostTaxes(),
            // 'payment_total' => $this->paymentTotal(),
            'grand_total'           => $this->totalPostTaxes(),
        ];
    }

    public function getResourceName()
    {
        return "cart_totals";
    }

}
