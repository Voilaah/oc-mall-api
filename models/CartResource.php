<?php

namespace Voilaah\MallApi\Models;

use Model;
use Illuminate\Http\Resources\Json\Resource;

Class CartResource extends Resource
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
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at->timestamp,
        ];
    }
}
