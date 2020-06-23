<?php

namespace Voilaah\MallApi\Classes\Transformers;


use OFFLINE\Mall\Models\Brand;
use League\Fractal\TransformerAbstract;

class BrandTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [];
    public $availableIncludes = [];

    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Brand $model)
    {
        return [
            'id'         => (int)$model->id,
            'name'       => (string)$model->name,
            'created_at' => $model->created_at->timestamp,
            'updated_at' => $model->updated_at->timestamp,
        ];
    }
}
