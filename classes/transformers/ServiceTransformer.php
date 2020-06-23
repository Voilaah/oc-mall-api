<?php

namespace Voilaah\MallApi\Classes\Transformers;

use OFFLINE\Mall\Models\Product;
use OFFLINE\Mall\Models\Service;
use League\Fractal\TransformerAbstract;
use Voilaah\MallApi\Classes\Transformers\PriceTransformer;
use Voilaah\MallApi\Classes\Transformers\CategoryTransformer;
use Voilaah\MallApi\Classes\Transformers\ImageSetTransformer;
use Voilaah\MallApi\Classes\Transformers\ProductPriceTransformer;
use Voilaah\MallApi\Classes\Transformers\ServiceOptionTransformer;

class ServiceTransformer extends TransformerAbstract
{
   /**
     * @var array
     */
    protected $defaultIncludes = ['options'];

    public $availableIncludes = [
        'options'
    ];

    protected $productModel;


    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Service $model)
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
        return $this->collection($model->prices, new ProductPriceTransformer());
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
