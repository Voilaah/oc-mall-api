<?php

namespace Voilaah\MallApi\Classes\Transformers;

use OFFLINE\Mall\Models\Product;
use League\Fractal\TransformerAbstract;
use Voilaah\MallApi\Classes\Transformers\BrandTransformer;
use Voilaah\MallApi\Classes\Transformers\ImageTransformer;
use Voilaah\MallApi\Classes\Transformers\ServiceTransformer;
use Voilaah\MallApi\Classes\Transformers\CategoryTransformer;
use Voilaah\MallApi\Classes\Transformers\ImageSetTransformer;
use Voilaah\MallApi\Classes\Transformers\ProductReviewTransformer;

class ProductTransformer extends TransformerAbstract
{
   /**
     * @var array
     */
    protected $defaultIncludes = ['image', 'image_sets', 'categories', 'variants'];

    public $availableIncludes = [
        'services',
        'categories',
        'accessories',
        'variants',
        'image_sets',
        'brand',
        'taxes',
        'reviews',
        'discounts',
        'files',
        'latest_file',
        'custom_fields',
    ];

    /**
     * Turn this item object into a generic array.
     *
     * @param $model
     * @return array
     */
    public function transform(Product $model)
    {
        $variant = $productBase = $productAdditional = [];

        $productBase = [
                'id' => (int)$model->id,
                'name' => (string)$model->name,
                'slug' => (string)$model->slug,
                'description' => (string)$model->description,
                'short_description' => (string)$model->description_short,
                'weight' => (int)$model->weight,
                'stock' => (int)$model->stock,
                'quantity' => (int)$model->quantity,
                'allow_out_of_stock_purchases' => (boolean)$model->allow_out_of_stock_purchases,
                'is_published' => (boolean)$model->published,
                'url' =>  route('products.show', ['slug' => $model->slug]),
                // 'url_slug' =>  route('products.show', ['slug' => $model->nestedSlug]),
                'created_at' => $model->created_at->timestamp,
                'updated_at' => $model->updated_at->timestamp,
            ];

        if ($model->inventory_management_method === 'variant') {
            $variant =  [

            ];
        } else {
            $productAdditional = [
            ];
        }

        return array_merge($productBase, $productAdditional, $variant);
    }

     /**
     * Embed Category
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeCategories($model)
    {
        return $this->collection($model->categories, new CategoryTransformer());
    }

    /**
     * Embed Images
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeImageSets($model)
    {
        return $this->collection($model->image_sets, new ImageSetTransformer);
    }

    /**
     * Embed Variants
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeVariants($model)
    {
        if ($model->variants->count() > 0)
            return $this->collection($model->variants, new VariantTransformer);
    }

    /**
     * Embed associated Services
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeServices($model)
    {
        if ($model->services->count() > 0)
            return $this->collection($model->services, new ServiceTransformer);
    }

    /**
     * Embed associated Services
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeReviews($model)
    {
        if ($model->reviews->count() > 0)
            return $this->collection($model->reviews, new ProductReviewTransformer);
    }

    /**
     * Embed Brand
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeBrand($model)
    {
        if ($model->brand)
            return $this->item($model->brand, new BrandTransformer);
    }

          /**
     * Embed Image
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeImage($model)
    {
        if ($model->image)
            return $this->item($model->image, new ImageTransformer);
    }

}
