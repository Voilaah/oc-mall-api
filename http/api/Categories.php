<?php namespace Voilaah\MallApi\Http\Api;

use Backend\Classes\Controller;
use Voilaah\MallApi\Interfaces\ResourceInterface;

/**
 * Categories Back-end Controller
 */
class Categories extends Controller implements ResourceInterface
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
        return 'categories';
    }

}
