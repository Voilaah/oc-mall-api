<?php

namespace Voilaah\MallApi\Models;

use Model;
use Illuminate\Http\Resources\Json\ResourceCollection;

Class CartProductResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection;
    }
}


