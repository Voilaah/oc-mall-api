<?php

namespace Voilaah\MallApi\Classes\Transformers;

use OFFLINE\Mall\Models\Product;
use OFFLINE\Mall\Models\Variant;
use League\Fractal\TransformerAbstract;
use Voilaah\MallApi\Classes\Transformers\PriceTransformer;
use Voilaah\MallApi\Classes\Transformers\CategoryTransformer;
use Voilaah\MallApi\Classes\Transformers\ImageSetTransformer;
use Voilaah\MallApi\Classes\Transformers\ProductPriceTransformer;

class VariantTransformer extends TransformerAbstract
{
   /**
     * @var array
     */
    protected $defaultIncludes = [ 'price'];

    public $availableIncludes = [
        'price',
        'prices',
        'categories',
        'accessories',
        'temp_images',
        'downloads',
        'product',
        'tax',
    ];

    protected $productModel;


    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Variant $model)
    {
        $this->productModel = $model;

        return [
            'id' => (int)$model->id,
            'name' => (string)$model->name,
            'slug' => (string)$model->slug,
            'published' => (boolean)$model->published,
            'allow_out_of_stock_purchases' => (boolean)$model->allow_out_of_stock_purchases,
            'stock' => (int)$model->stock,
            'weight' => (double)$model->weight,
            // 'price' => new PriceTransformer($model->price)

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
    public function includeTempImages($model)
    {
        return $this->collection($model->temp_images, new ImageSetTransformer);
    }



}
