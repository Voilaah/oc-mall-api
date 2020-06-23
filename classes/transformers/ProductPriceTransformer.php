<?php

namespace Voilaah\MallApi\Classes\Transformers;

use OFFLINE\Mall\Models\ProductPrice;
use League\Fractal\TransformerAbstract;

class ProductPriceTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [];

    public $availableIncludes = [];


    public function transform(ProductPrice $model)
    {
       return [
            'price_value' => $model->price,
            'price_decimal' => $model->decimal,
        ];
    }

}
