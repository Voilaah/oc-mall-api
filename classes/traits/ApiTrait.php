<?php

namespace Voilaah\MallApi\Classes\Traits;

use Auth;
use Input;
use OFFLINE\Mall\Models\Cart;
use OFFLINE\Mall\Models\Product;
use OFFLINE\Mall\Models\CartProduct;
use RLuders\JWTAuth\Classes\JWTAuth;
use OFFLINE\Mall\Classes\Traits\HashIds;
use Voilaah\MallApi\Models\CartResource;
use RainLab\User\Models\User as UserModel;
use Tymon\JWTAuth\Exceptions\JWTException;
use Voilaah\MallApi\Models\CartProductResource;
// use Vdomah\JWTAuth\Models\User as UserModel;

trait ApiTrait
{
    use HashIds;



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
     * Fetch the item from the user's cart.
     *
     * This fails if an item is modified that is not in the
     * currently logged in user's cart.
     *
     * @param CartModel $cart
     * @param mixed     $id
     *
     * @return mixed
     * @throws ModelNotFoundException
     */
    protected function getProductFromCart(Cart $cart, $id)
    {
        return CartProduct
            ::whereHas('cart', function ($query) use ($cart) {
                $query->where('id', $cart->id);
            })
            ->where('id', $id)
            ->firstOrFail();
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

    /**
     * [returnAsked description]
     * @param  string $value [description]
     * @return [type]        [description]
     */
    protected function returnAsked($value='')
    {
        return ($value == self::DEFAULT_RETURN_ITEM)
            ? new CartProductResource($this->cartItem)
            : new CartResource($this->cart);
    }


}
