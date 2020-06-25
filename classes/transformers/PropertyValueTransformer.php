<?php

namespace Voilaah\MallApi\Classes\Transformers;

use OFFLINE\Mall\Models\PropertyValue;
use OFFLINE\Mall\Classes\Utils\Money;
use OFFLINE\Mall\Models\PropertyGroup;
use League\Fractal\TransformerAbstract;

class PropertyValueTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [ ];

    public $availableIncludes = [

    ];


    public function transform($collection)
    {
        $model = $collection->mapToGroups(function ($item, $key) {
            return [
                $item['property_id'] => [
                    'index_value' => (string)$item->index_value,
                    'value' => (array)$item->value,
                ]
            ];
        });

        return $model->toArray();
    }

}
