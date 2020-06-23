<?php

namespace Voilaah\MallApi\Classes\Transformers;


use OFFLINE\Mall\Models\Category;
use League\Fractal\TransformerAbstract;
use Voilaah\MallApi\Classes\Transformers\ProductTransformer;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = ['children'];

    public $availableIncludes = [
        'children',
        'products',
    ];
    /**
     * Turn this model object into a generic array.
     *
     * @param $model
     * @return array
     */
    public function transform(Category $model)
    {
        return [
            'id'            => (int)$model->id,
            'parent_id'     => ($model->parent_id)?:null,
            'name'          => (string)$model->name,
            'slug'          => (string)$model->nestedslug,
            'description'   => (string)$model->description,
            'url'           => route('categories.show', ['recordId' => $model->nestedslug]),
            'created_at'    => $model->created_at->timestamp,
            'updated_at'    => $model->updated_at->timestamp,
        ];
    }

    /**
     * Embed Category
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeChildren($model)
    {
        if ($model->children->count() > 0 )
            return $this->collection($model->children, new CategoryTransformer());
    }

    /**
     * Embed Products
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeProducts($model)
    {
        if ($model->products->count() > 0 )
            return $this->collection($model->products, new ProductTransformer());
    }
}
