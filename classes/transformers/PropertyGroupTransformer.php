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
    protected $defaultIncludes = ['filterable_properties', 'properties_values'];

    public $availableIncludes = [
        'filterable_properties',
        'properties_values',
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

    protected function includePropertiesValues($model)
    {
        if ($model->filterable_properties->count() > 0)
            return $this->collection($model->filterable_properties, new PropertyTransformer());
    }

}
