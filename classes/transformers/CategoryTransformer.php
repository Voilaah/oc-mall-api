<?php

namespace Voilaah\MallApi\Classes\Transformers;


use OFFLINE\Mall\Models\Category;
use OFFLINE\Mall\Models\PropertyGroup;
use League\Fractal\TransformerAbstract;
use Voilaah\MallApi\Classes\Transformers\ImageTransformer;
use Voilaah\MallApi\Classes\Transformers\ProductTransformer;
use Voilaah\MallApi\Classes\Transformers\PropertyGroupTransformer;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [];

    public $availableIncludes = [
        'children',
        'products',
        'image',
        'property_groups'
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

     /**
     * Get all PropertyGroups in this Category.
     * code from Mall component ProductFilters method getPropertyGroups()
     * @return mixed
     */
    protected function includePropertyGroups($model)
    {
        $property_groups = $model
            ->load('property_groups.translations')
            ->inherited_property_groups
            ->load('filterable_properties.translations')
            ->reject(function (PropertyGroup $group) {
                return $group->filterable_properties->count() < 1;
            })->sortBy('pivot.sort_order');

            // trace_log($property_groups->toArray());

        if ($property_groups->count() > 0)
            return $this->collection($property_groups, new PropertyGroupTransformer());

    }
}
