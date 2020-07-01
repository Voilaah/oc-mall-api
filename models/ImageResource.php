<?php

namespace Voilaah\MallApi\Models;


class ImageResource extends SimpleApiResource
{
    public function toArray($request)
    {
       return [
            'file_name'     => (string)$this->file_name,
            'file_size'     => (int)$this->file_size,
            'content_type'  => (string)$this->content_type,
            'path'          => (string)$this->path,
        ];
    }


    public function getResourceName()
    {
        return "image";
    }

}
