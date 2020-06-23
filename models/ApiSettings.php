<?php

namespace Voilaah\MallApi\Models;

use Model;

/**
 * ApiSettings Model
 */
class ApiSettings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];
    public $settingsCode = 'voilaah_mallapi_settings';
    public $settingsFields = '$/voilaah/mallapi/models/settings/fields.yaml';
}
