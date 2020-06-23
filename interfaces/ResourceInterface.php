<?php

namespace Voilaah\MallApi\Interfaces;


interface ResourceInterface
{

    /**
     * Return the resource name used by the controller
     * @return mixed
     */
    public function getResourceName();

}
