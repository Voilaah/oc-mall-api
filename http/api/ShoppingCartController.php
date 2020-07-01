<?php

namespace Voilaah\MallApi\Http\Api;

use Auth;
use Input;
use Cookie;
use Request;
use Session;
use Response;
use Exception;
use OFFLINE\Mall\Models\Cart;
use OFFLINE\Mall\Models\Variant;
use Illuminate\Routing\Controller;
use OFFLINE\Mall\Models\CartProduct;
use RLuders\JWTAuth\Classes\JWTAuth;
use Illuminate\Database\QueryException;
use OFFLINE\Mall\Models\ShippingMethod;
use Voilaah\MallApi\Models\CartResource;
use OFFLINE\Mall\Models\Cart as CartModel;
use Voilaah\MallApi\Classes\Traits\ApiTrait;
use October\Rain\Exception\ValidationException;
use Voilaah\MallApi\Models\CartProductResource;
use OFFLINE\Mall\Classes\Exceptions\OutOfStockException;

/**
 * Class ShoppingCartController.
 *
 * @author Christophe Vidal <chris@voilaah.com>
 */
class ShoppingCartController extends Controller
{

    use ApiTrait;

    public const DEFAULT_RETURN_CART = 'cart';

    public const DEFAULT_RETURN_ITEM = 'item';

    protected $user;

    protected $cart;

    protected $cartItem;

    /**
     * Send the forgot password request
     *
     * @return Illuminate\Http\Response
     */
    public function __construct(JWTAuth $auth)
    {
        $this->user = $auth->user();
        // $this->user = Auth::getUser();
    }

    public function index()
    {
        $this->setData();
        return new CartResource($this->cart);
    }

    protected function setData()
    {
        try {
            $this->cart = CartModel::byUser($this->user);
            $this->getCart();
        } catch (QueryException $e) {
            $this->cart = $this->bySession();
            $this->getCart();
        } catch (Exception $e) {
            trace_log($e);
        }

    }

    /**
     * [getCart description]
     * @return [type] [description]
     */
    protected function getCart()
    {
        $this->cart->load(['products', 'products.custom_field_values', 'discounts']);
        if ($this->cart->shipping_method_id === null) {
            $this->cart->setShippingMethod(ShippingMethod::getDefault());
        }
        $this->cart->validateShippingMethod();
    }

    /**
     * override and rewrite this Mall method from CartSession to
     * fix the QueryException threw with a cart_session_id too long
     * @return [type] [description]
     */
    protected function bySession(): Cart
    {
        Session::remove('cart_session_id');
        $sessionId = Session::get('cart_session_id') ?? Cookie::get('cart_session_id') ?? str_random(100);

        /* added code */
        if (strlen($sessionId) > 190 )
            $sessionId = substr($sessionId, 0, 190);
        /* end */

        Cookie::queue('cart_session_id', $sessionId, 9e6);
        Session::put('cart_session_id', $sessionId);

        return Cart::orderBy('created_at', 'DESC')->firstOrCreate(['session_id' => $sessionId]);
    }

    public function show()
    {
        trace_log('show');
    }

    public function store()
    {
        $this->cartItem = null;
        $this->cart = Cart::byUser($this->user);

        /* building the data */
        $variant = null;
        $values = null;

        $this->product = $this->getProduct();

        $serviceOptions = Input::get('service_options', null);
        $serviceOptions = array_filter($serviceOptions);

        $quantity = (int)input('quantity', $product->quantity_default ?? 1);
        if ($quantity < 1) {
            throw new ValidationException(['quantity' => trans('offline.mall::lang.common.invalid_quantity')]);
        }

        $variantId = Input::get('variant_id', null);
        // $variantId = $this->decode($this->param('variant'));
        if ($variantId !== null) {
            // In case a Variant is added we have to retrieve the model first by the selected props.
            // $variant = $this->getVariantByPropertyValues(post('props'));
            $variant = Variant::findOrFail($variantId);
        }

        try {
            $this->cartItem = $this->cart->addProduct($this->product, $quantity, $variant, $values, $serviceOptions);
        } catch (OutOfStockException $e) {
            throw new ValidationException(['quantity' => trans('offline.mall::lang.common.stock_limit_reached')]);
        }

        $returnAsked = input('return_asked') ? : self::DEFAULT_RETURN_ITEM;

        return $this->returnAsked($returnAsked);

        // return [
        //     'item'     => $this->dataLayerArray($product, $variant),
        //     'currency' => optional(Currency::activeCurrency())->only('symbol', 'code', 'rate', 'decimals'),
        //     'quantity' => $quantity,
        //     'new_items_count' => optional($cart->products)->count() ?? 0,
        //     'new_items_quantity' => optional($cart->products)->sum('quantity') ?? 0,
        //     'added'    => true,
        // ];
    }

    /**
     * [update description]
     * @param  [type] $cartItemId [description]
     * @return [type]             [description]
     */
    public function update($cartItemId = null)
    {
        // trace_log('update ' . $cartItemId);

        $id = $this->decode($cartItemId);

        $this->cart     = CartModel::byUser($this->user);
        $product        = $this->getProductFromCart($this->cart, $id);

        try {
            $this->cart->setQuantity($product->id, (int)input('quantity'));
        } catch (OutOfStockException $e) {
            new ValidationException(trans('offline.mall::lang.common.out_of_stock', ['quantity' => $e->product->stock]));
            return;
        } finally {
            $this->setData();
        }

        $returnAsked = input('return_asked') ? : self::DEFAULT_RETURN_ITEM;

        if ($returnAsked == self::DEFAULT_RETURN_ITEM)
            $this->cartItem = $this->products->find($cartProductId);

        return $this->returnAsked($returnAsked);
    }

    /**
     * [destroy description]
     * @return [type] [description]
     */
    public function destroy($cartItemId = null)
    {
        // trace_log('remove from cart ' . $cartItemId);

        $id = $this->decode($cartItemId);

        $cart = CartModel::byUser($this->user);

        $product = $this->getProductFromCart($cart, $id);

        $cart->removeProduct($product);

        $this->setData();

        return $this->returnAsked(self::DEFAULT_RETURN_CART);

        // return [
        //     'item'     => $this->dataLayerArray($product->product, $product->variant),
        //     'quantity' => $product->quantity,
        //     'new_items_count' => optional($cart->products)->count() ?? 0,
        //     'new_items_quantity' => optional($cart->products)->sum('quantity') ?? 0,
        // ];
    }

    /**
     * Return the resource name used by the controller
     * @return mixed
     */
    public function getResourceName() {
        return 'cart';
    }
}
