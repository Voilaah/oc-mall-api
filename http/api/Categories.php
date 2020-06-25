<?php namespace Voilaah\MallApi\Http\Api;

use Backend\Classes\Controller;
use OFFLINE\Mall\Models\Category;
use Voilaah\MallApi\Interfaces\ResourceInterface;
use Voilaah\MallApi\Classes\Transformers\CategoryTransformer;

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

    /**
     * return the filterbale properties and their values for this category
     * @param  [type] $recordId [description]
     * @return [type]           [description]
     */
    public function showProperties($recordId = null)
    {
        $transformer = new CategoryTransformer;
        $transformer->setDefaultIncludes(['children', 'property_groups']);
        $category = Category::find($recordId);

        return $this->respondWithItem($category, $transformer, 200);

    }

}
