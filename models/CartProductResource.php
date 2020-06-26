<?php

namespace Voilaah\MallApi\Models;

use Model;
use Illuminate\Http\Resources\Json\Resource;

Class CartProductResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'session_id' => $this->session_id,
        ];
    }
}
