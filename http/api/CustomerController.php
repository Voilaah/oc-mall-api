<?php namespace Voilaah\MallApi\Http\Api;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use RLuders\JWTAuth\Classes\JWTAuth;
use Voilaah\RestApi\Interfaces\ResourceInterface;

class CustomerController extends Controller implements ResourceInterface
{
    public $implement = [
        'Voilaah.RestApi.Behaviors.RestController'
    ];

    public $restConfig = 'config_rest.yaml';
    /**
     * Send the forgot password request
     *
     * @return Illuminate\Http\Response
     */
    public function __invoke(JWTAuth $auth)
    {
        if (!$user = $auth->user()) {
            return response()->json(
                ['error' => 'user_not_found'],
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json(compact('user'));
    }

    /**
     * Return the resource name used by the controller
     * @return mixed
     */
    public function getResourceName() {
        return 'user';
    }

}
