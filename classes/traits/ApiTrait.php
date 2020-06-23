<?php

namespace Voilaah\MallApi\Classes\Traits;

use Auth;
use RLuders\JWTAuth\Classes\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use RainLab\User\Models\User as UserModel;
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
}
