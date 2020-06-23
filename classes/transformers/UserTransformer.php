<?php

namespace Voilaah\MallApi\Classes\Transformers;


use OFFLINE\Mall\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
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
    public function transform(User $model)
    {
        return [
            'id'         => (int)$model->id,
            'name'       => (string)$model->name,
            'email'       => (string)$model->email,
            'created_at' => $model->created_at->timestamp,
            'updated_at' => $model->updated_at->timestamp,
        ];
    }
}
