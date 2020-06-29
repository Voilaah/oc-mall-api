<?php

namespace Voilaah\MallApi\Models;

use Model;
use Illuminate\Http\Resources\Json\Resource;
use Voilaah\MallApi\Behaviors\RestController;
use Voilaah\MallApi\Interfaces\ResourceInterface;


Abstract Class SimpleApiResource extends Resource implements ResourceInterface
{

    public function with($request)
    {
        return [
            "version" => strtolower(RestController::API_VERSION),
            "resource" => strtolower($this->getResourceName()),
            "path"      => request()->path(),
        ];
    }

}
