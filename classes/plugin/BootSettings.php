<?php

namespace Voilaah\MallApi\Classes\Plugin;

use Voilaah\MallApi\Models\ApiSettings;

trait BootSettings
{
    public function registerSettings()
    {
        return [
            'api_settings'          => [
                'label'       => 'voilaah.mallapi::lang.general_settings.label',
                'description' => 'voilaah.mallapi::lang.general_settings.description',
                'category'    => 'offline.mall::lang.general_settings.category',
                'icon'        => 'icon-code',
                'class'       => ApiSettings::class,
                'order'       => 500,
                'permissions' => ['voilaah.mallapi.settings.manage'],
                'keywords'    => 'mall api mallapi general',
            ]
        ];
    }
}
