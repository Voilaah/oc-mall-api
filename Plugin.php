<?php namespace Voilaah\MallApi;

use System\Classes\PluginBase;
use Voilaah\MallApi\Classes\Plugin\BootSettings;
use Voilaah\MallApi\Classes\Plugin\BootExtensions;

class Plugin extends PluginBase
{
    use BootSettings;
    use BootExtensions;
    /**
     * Plugin dependencies.
     *
     * @var array
     */
    public $require = [
        'RainLab.User',
        'OFFLINE.Mall',
        'OFFLINE.SiteSearch',
        'RLuders.CORS',
        'RLuders.JWTAuth'
    ];

    public function boot()
    {

    }

}
