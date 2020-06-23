<?php

namespace Voilaah\MallApi\Classes\Transformers;

use OFFLINE\Mall\Models\ImageSet;
use League\Fractal\TransformerAbstract;
use Voilaah\MallApi\Classes\Transformers\ImageTransformer;

class ImageSetTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = ['images'];

    public $availableIncludes = [
        'images'
    ];


    public function transform(ImageSet $model)
    {
       return [
            'name' => (string)$model->name,
            'is_main_set' => (boolean)$model->is_main_set,

        ];
    }

            /**
     * Embed Images
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeImages($model)
    {
        return $this->collection($model->images, new ImageTransformer);
    }

}
