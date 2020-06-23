<?php

namespace Voilaah\MallApi\Classes\Transformers;

use OFFLINE\Mall\Models\Price;
use OFFLINE\Mall\Classes\Utils\Money;
use League\Fractal\TransformerAbstract;

class PriceTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [];
    public $availableIncludes = [];


    public function transform(Price $model)
    {
        // info("======");
        // info($model);
       return [
            'raw' => $model->price,
            'decimals' => $model->currency->decimals,
            'price_value' => app(Money::class)->round($model->price),
            'price_formatted' => app(Money::class)->format($model->price),
            // 'price_formatted' => (string)$model->price_formatted,
            'currency' => $model->currency->code,
            'old_price' => $model->product ? $model->product->oldPrice()->string : null,
        ];
    }

}
