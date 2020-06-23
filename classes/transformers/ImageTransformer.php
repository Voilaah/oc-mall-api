<?php

namespace Voilaah\MallApi\Classes\Transformers;

use System\Models\File;
use League\Fractal\TransformerAbstract;

class ImageTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [];
    public $availableIncludes = [];


    public function transform(File $model)
    {
       return [
            'file_name' => (string)$model->file_name,
            'file_size' => (int)$model->file_size,
            'content_type' => (string)$model->content_type,
            'path' => (string)$model->path,
        ];
    }

}
