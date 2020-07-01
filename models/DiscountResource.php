<?php

namespace Voilaah\MallApi\Models;

class DiscountResource extends SimpleApiResource
{
    public function toArray($request)
    {
       return [
            'id'                    => (int)$this->id,
        ];
    }

    public function getResourceName()
    {
        return "discount";
    }

}
