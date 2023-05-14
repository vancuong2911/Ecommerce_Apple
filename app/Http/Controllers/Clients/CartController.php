<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Service\CartsService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartsService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        if (!Auth::user()) {
            return redirect()->route('login');
        }

        $cartData = $this->cartService->getCartData(Auth::user()->id);
        return view("cart", $cartData);
    }

    public function store(Request $request, $id)
    {

        if (!Auth::user()) {

            return redirect()->route('login');
        }

        $product = Product::find($id);
        $quantity = $request->number;
        if (Cart::where('product_id', '=', $id)->where('user_id', Auth::user()->id)->where('product_order', 'no')->exists()) {
            $quant = DB::table('carts')->where('product_id', '=', $id)->where('user_id', Auth::user()->id)->where('product_order', 'no')->value('quantity');

            $quantity = $quantity + (int) $quant;

            DB::table('carts')->where('product_id', '=', $id)->where('user_id', Auth::user()->id)->where('product_order', 'no')->update([
                'quantity' => $quantity,
                'subtotal' => $quantity * $product->price
            ]);
        } else {
            DB::table('carts')->insert([
                'product_id' => $product->id,
                'user_id' => Auth::user()->id,
                'product_order' => "no",
                'shipping_address' => 'N/A',
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'subtotal' => $quantity * $product->price
            ]);
        }


        return back();
    }

    public function destroy($id)
    {
        $product = Cart::find($id);
        $product->delete();

        return redirect()->route('cart');
    }

    public function checkout($total)
    {
        return view("checkout", compact('total'));
    }
}
