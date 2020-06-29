<?php

namespace Voilaah\MallApi\Classes\Traits;

use Auth;
use Input;
use OFFLINE\Mall\Models\Product;
use RLuders\JWTAuth\Classes\JWTAuth;
use RainLab\User\Models\User as UserModel;
use Tymon\JWTAuth\Exceptions\JWTException;
// use Vdomah\JWTAuth\Models\User as UserModel;

trait ApiTrait
{

    /**
     * The JWTAuth
     *
     * @var RLuders\JWTAuth\Classes\JWTAuth
     */
    protected $auth;

    protected $user;

    public function getUser()
    {
        try {
            if ($this->user = $this->auth->parseToken()->toUser()) {
                return $this->user;
            }
            return null;

        } catch (JWTException $e) {
            return null;
        }

        // $token = JWTAuth::parseToken()->getToken();
        // if ($token)
        //     return $this->user = JWTAuth::authenticate( $token );

        // return null;
    }


    /**
     * [getProduct description]
     * @return [type] [description]
     */
    protected function getProduct($id = null)
    {
        if (null == $id)
            $id = Input::get("product_id");

        return Product::findOrFail($id);
    }
}
