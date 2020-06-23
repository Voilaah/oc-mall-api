<?php

namespace Voilaah\MallApi\Classes\Transformers;

use OFFLINE\Mall\Models\Review;
use League\Fractal\TransformerAbstract;

class ProductReviewTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [];

    public $availableIncludes = [];


    public function transform(Review $model)
    {
       return [
            'id'            => (int)$model->id,
            'rating'        => (int)$model->rating,
            'title'         => (string)$model->title,
            'description'   => (string)$model->description,
            'pros'          => (array)$model->pros,
            'cons'          => (array)$model->cons
        ];
    }

}
