<?php namespace Voilaah\MallApi\Http\Api;

use Backend\Classes\Controller;
use Voilaah\MallApi\Interfaces\ResourceInterface;

/**
 * Brands Back-end Controller
 */
class PropertyGroups extends Controller implements ResourceInterface
{
    public $implement = [
        'Voilaah.MallApi.Behaviors.RestController'
    ];

    public $restConfig = 'config_rest.yaml';

    /**
     * Return the resource name used by the controller
     * @return mixed
     */
    public function getResourceName() {
        return 'property_groups';
    }

}
