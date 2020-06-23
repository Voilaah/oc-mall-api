<?php

namespace Voilaah\MallApi\Classes\Transformers;


use OFFLINE\Mall\Models\ServiceOption;
use League\Fractal\TransformerAbstract;
use Voilaah\MallApi\Classes\Transformers\PriceTransformer;

class ServiceOptionTransformer extends TransformerAbstract
{
   /**
     * @var array
     */
    protected $defaultIncludes = ['prices'];

    public $availableIncludes = [
        'prices'
    ];

    protected $productModel;


    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(ServiceOption $model)
    {
        $this->productModel = $model;

        return [
            'id' => (int)$model->id,
            'name' => (string)$model->name,
            'description' => (string)$model->description,
        ];
    }

     /**
     * Embed Prices
     *
     * @return League\Fractal\Resource\Item
     */
    public function includePrice($model)
    {
        if ($model->price)
            return $this->item($model->price(), new PriceTransformer());
    }

     /**
     * Embed Prices
     *
     * @return League\Fractal\Resource\Item
     */
    public function includePrices($model)
    {
        return $this->collection($model->prices, new PriceTransformer());
    }

        /**
     * Embed Images
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeOptions($model)
    {
        return $this->collection($model->options, new ServiceOptionTransformer);
    }



}
