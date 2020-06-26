<?php

namespace Voilaah\MallApi\Http\Api;

use Auth;
use Response;
use Illuminate\Routing\Controller;
use OFFLINE\Mall\Models\CartProduct;
use RLuders\JWTAuth\Classes\JWTAuth;
use Voilaah\MallApi\Models\CartResource;
use OFFLINE\Mall\Models\Cart as CartModel;

/**
 * Class ShoppingCartController.
 *
 * @author Christophe Vidal <chris@voilaah.com>
 */
class ShoppingCartController extends Controller
{

    protected $user;

    protected $cart;

    /**
     * Send the forgot password request
     *
     * @return Illuminate\Http\Response
     */
    public function __construct(JWTAuth $auth)
    {
        // $this->user = $auth->user();
        $this->user = Auth::getUser();
        $this->setData();
    }

    public function index()
    {

        return new CartResource($this->cart);

    }

    protected function setData()
    {
        $this->cart = CartModel::byUser($this->user);
        $this->cart->load(['products', 'products.custom_field_values', 'discounts']);
        if ($this->cart->shipping_method_id === null) {
            $this->cart->setShippingMethod(ShippingMethod::getDefault());
        }
        $this->cart->validateShippingMethod();

    }

    public function show()
    {
        # code...
    }

    public function store()
    {
        # code...
    }

    public function update()
    {
        # code...
    }

    public function destroy()
    {
        # code...
    }

    /**
     * Return the resource name used by the controller
     * @return mixed
     */
    public function getResourceName() {
        return 'cart';
    }
}
