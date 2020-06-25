<?php

namespace Voilaah\MallApi\Classes\Transformers;

use OFFLINE\Mall\Models\Property;
use OFFLINE\Mall\Classes\Utils\Money;
use OFFLINE\Mall\Models\PropertyGroup;
use League\Fractal\TransformerAbstract;

class PropertyTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [ ];

    public $availableIncludes = [

    ];


    public function transform(Property $model)
    {
        $options = [];
        if ($model->options && count($model->options) > 0) {
            $options = ['options' => $model->options];
        }
        return array_merge(
            [
                'id' => (int)$model->id,
                'name' => (string)$model->name,
                'slug' => (string)$model->slug,
                'type' => (string)$model->type,
                'unit' => (string)$model->unit,
                'filter_type' => (string)$model->pivot->filter_type,
            ],
            $options
        );
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
