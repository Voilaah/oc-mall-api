<?php

namespace Voilaah\MallApi\Classes\Plugin;

use App;
use OFFLINE\Mall\Classes\CategoryFilter\SortOrder\SortOrder;

trait BootExtensions
{
    protected function registerExtensions()
    {
        // $this->extendMALL();
    }

    protected function extendMALL()
    {
        SortOrder::extend(function($model) {
            if (!isset($model->direction))
                $model->addDynamicProperty('direction');
            $model->addDynamicMethod('setDirection', function($direction) use ($model) {
                return $model->direction = $direction;
            });
            $model->addDynamicMethod('getDirection', function($direction) use ($model) {
                return $model->direction;
            });
        });
    }
}
