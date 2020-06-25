<?php

namespace Voilaah\MallApi\Classes\Transformers;

use OFFLINE\Mall\Models\PropertyGroup;
use OFFLINE\Mall\Classes\Utils\Money;
use League\Fractal\TransformerAbstract;

class PropertyGroupTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = ['filterable_properties'];

    public $availableIncludes = [
        'filterable_properties',
    ];


    public function transform(PropertyGroup $model)
    {
       return [
            'id' => (int)$model->id,
            'name' => (string)$model->name,
            'display_name' => (string)$model->display_name,
            'description' => (string)$model->description,
        ];
    }

    protected function includeFilterableProperties($model)
    {
        if ($model->filterable_properties->count() > 0)
            return $this->collection($model->filterable_properties, new PropertyTransformer());
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
