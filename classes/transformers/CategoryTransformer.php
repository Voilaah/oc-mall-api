<?php

namespace Voilaah\MallApi\Classes\Transformers;


use OFFLINE\Mall\Models\Category;
use OFFLINE\Mall\Models\Property;
use OFFLINE\Mall\Models\PropertyGroup;
use League\Fractal\TransformerAbstract;
use Voilaah\MallApi\Classes\Transformers\ImageTransformer;
use Voilaah\MallApi\Classes\Transformers\ProductTransformer;
use Voilaah\MallApi\Classes\Transformers\VariantTransformer;
use Voilaah\MallApi\Classes\Transformers\PropertyGroupTransformer;
use Voilaah\MallApi\Classes\Transformers\PropertyValueTransformer;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * All available property filters.
     *
     * @var Collection
     */
    public $propertyGroups;
        /**
     * All available property values.
     *
     * @var Collection
     */
    protected $properties_values;


        /**
     * The active category.
     *
     * @var Category
     */
    protected $category;
    /**
     * A Collection of all subcategories.
     *
     * @var Collection
     */
    protected $categories;

    /**
     * A collection of available Property models.
     *
     * @var Collection
     */
    public $props;

    /**
     * @var array
     */
    protected $defaultIncludes = [];

    public $availableIncludes = [
        'children',
        'products',
        'image',
        'property_groups',
        'properties_values',
    ];
    /**
     * Turn this model object into a generic array.
     *
     * @param $model
     * @return array
     */
    public function transform(Category $model)
    {
        $this->categories = collect([$model]);
        if (true /*$this->includeChildren*/) {
            $this->categories = $model->getAllChildrenAndSelf();
        }

        return [
            'id'            => (int)$model->id,
            'parent_id'     => ($model->parent_id)?:null,
            'name'          => (string)$model->name,
            'slug'          => (string)$model->nestedslug,
            'description'   => (string)$model->description,
            'url'           => route('categories.show', ['recordId' => $model->id]),
            'url_slug'      => route('categories.show', ['recordId' => $model->nestedslug]),
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
        $this->propertyGroups = $model
            ->load('property_groups.translations')
            ->inherited_property_groups
            ->load('filterable_properties.translations')
            ->reject(function (PropertyGroup $group) {
                return $group->filterable_properties->count() < 1;
            })->sortBy('pivot.sort_order');

        $this->setProps();

        if ($this->propertyGroups->count() > 0)
            return $this->collection($this->propertyGroups, new PropertyGroupTransformer());

    }

    public function includePropertiesValues($model)
    {

        return $this->collection($this->values->values(), new PropertyValueTransformer());
    }

            /**
     * Pull all the properties from all property groups. These are needed
     * to generate possible filter values.
     *
     * @return void
     */
    protected function setProps()
    {
        $this->values = Property::getValuesForCategory($this->categories);
        $valueKeys    = $this->values->keys();
        $props        = $this->propertyGroups->flatMap->filterable_properties->unique();

        // Remove any property that has no available filters.
        $this->props = $props->filter(function (Property $property) use ($valueKeys) {
            return $valueKeys->contains($property->id);
        });

        $groupKeys = $this->props->pluck('pivot.property_group_id');

        // Remove any property group that has no available properties.
        $this->propertyGroups = $this->propertyGroups->filter(function (PropertyGroup $group) use ($groupKeys) {
            return $groupKeys->contains($group->id);
        });
    }
}
