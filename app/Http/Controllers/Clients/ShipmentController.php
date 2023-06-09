<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Repositories\Carts\CartsRepository;
use Illuminate\Support\Facades\Mail;

use App\Service\CartsService;
use App\Service\ShipmentsService;
use App\Repositories\Orders\OrdersRepository;
use App\Repositories\Products\ProductsRepository;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class ShipmentController extends Controller
{
    protected $cartsSerivce;
    protected $cartsRepository;
    protected $ordersRepository;
    protected $shipmentsService;
    protected $productsRepository;

    public function __construct(CartsService $cartsSerivce, CartsRepository $cartsRepository, OrdersRepository $ordersRepository, ShipmentsService $shipmentsService, ProductsRepository $productsRepository)
    {
        $this->cartsSerivce = $cartsSerivce;
        $this->cartsRepository = $cartsRepository;
        $this->ordersRepository = $ordersRepository;
        $this->shipmentsService = $shipmentsService;
        $this->productsRepository = $productsRepository;
    }

    public function place_order($total)
    {

        return view('place_order', compact('total'));
    }


    public function send(Request $request, $total)
    {
        $total = Session::get('total');

        $invoice = Session::get('invoice');
        $user = Auth::user();
        $post_data = array();
        $post_data['total_amount'] = $total;
        $post_data['currency'] = "USD";
        $post_data['tran_id'] = $invoice; // tran_id mã hóa đơn

        # Thông tin khách hàng
        $post_data['cus_name'] = $user->name;
        $post_data['cus_email'] = $user->email;
        $post_data['cus_add1'] = $request->address;
        $post_data['cus_phone'] = $user->phone;

        // Trạng thái đang chờ xử lý
        // Lưu id người dùng
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $orderData = $this->ordersRepository->createOrderData($request->address);
        $invoice = $orderData['invoice'];
        $data = $orderData['data'];

        $products = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->get();

        $total = $this->ordersRepository->calculateTotalPrice(Auth::user()->id);
        $total_extra_charge = DB::table('charges')->sum('price');

        $carts_amount = $this->cartsRepository->getCartsAmountByUserId(Auth::user()->id);

        $without_discount_price = $total - $total_extra_charge;
        $discount_price = 0;

        $coupon_code = NULL;

        if ($carts_amount > 0) {
            foreach ($products as $cart) {
                $coupon_code = $cart->coupon_id;
            }
        }

        if ($coupon_code != NULL) {
            $cart = $this->cartsSerivce->getCartData(Auth::user()->id);
            $total = $cart["total_price"] + $total_extra_charge;
        } else {
            $total = $this->ordersRepository->calculateTotalPrice(Auth::user()->id);
        }
        $cart = $this->cartsSerivce->getCartData(Auth::user()->id);

        $carts = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->update($data);

        $coupon_code_price = DB::table('coupons')->where('code', $coupon_code)->value('percentage');
        $coupon_code_price = floor($coupon_code_price);

        $discount_price = $cart["discount_price"];

        $data["title"] = "From MiniStore admin";
        $data["body"] = "Your reservation have been Placed Successfully";
        $data["total"] = $total;
        $data["without_discount_price"] = $without_discount_price;
        $data["discount_price"] = $discount_price;

        if ($invoice == NULL) {
            $invoice = "MiniStore";
        }
        $extra_charge = DB::table('charges')->get();

        Session::put('products', $products);
        Session::put('invoice', $invoice);
        Session::put('total', $total);
        Session::put('extra_charge', $extra_charge);
        Session::put('discount_price', $discount_price);
        Session::put('without_discount_price', $without_discount_price);
        Session::put('date', date("Y-m-d"));

        $pdf = PDF::loadView('mails.PaymentMail', ['data' => $data, 'products' => $products]);

        if ($carts) {
            Mail::send('mails.PaymentMail', ['data' => $data], function ($message) use ($data, $pdf) {
                $message->to(Auth::user()->email, Auth::user()->email)
                    ->subject($data["title"])
                    ->attachData($pdf->output(), "Order Copy.pdf");
            });
        }

        return view('Confirm_order', compact('invoice', 'products', 'total', 'without_discount_price', 'discount_price'));
    }

    public function my_order()
    {
        if (!Auth::user()) {

            return redirect()->route('login');
        }

        $carts = Cart::all()->where('user_id', Auth::user()->id)->where('product_order', '!=', 'no');

        $total_price = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', '!=', 'no')->sum('subtotal');
        return view("my_order", compact('carts', 'total_price'));
    }
    public function trace()
    {
        if (!Auth::user()) {

            return redirect()->route('login');
        }

        $carts = Cart::all()->where('user_id', Auth::user()->id)->where('product_order', 'yes');
        $total_price = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->sum('subtotal');
        return view("trace", compact('carts', 'total_price'));
    }

    public function trace_confirm(Request $req)
    {
        if (!Auth::user()) {

            return redirect()->route('login');
        }
        $carts = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', '!=', 'no')->where('invoice_no', $req->invoice)->count();

        if ($carts == 0) {

            session()->flash('wrong', 'Invaild Invoice no !');
            return back();
        }

        $carts = Cart::all()->where('user_id', Auth::user()->id)->where('product_order', '!=', 'no')->where('invoice_no', $req->invoice);
        $total_price = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', '!=', 'no')->where('invoice_no', $req->invoice)->sum('subtotal');
        $carts_amount = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', '!=', 'no')->where('invoice_no', $req->invoice)->count();
        $without_discount_price = $total_price;
        $discount_price = 0;
        $coupon_code = NULL;

        if ($carts_amount > 0) {
            foreach ($carts as $cart) {

                $coupon_code = $cart->coupon_id;
            }
        }

        if ($coupon_code != NULL) {

            $total_price = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', '!=', 'no')->where('invoice_no', $req->invoice)->sum('subtotal');

            $coupon_code_price = DB::table('coupons')->where('code', $coupon_code)->value('percentage');

            $coupon_code_price = floor($coupon_code_price);

            $discount_price = (($total_price * $coupon_code_price) / 100);
            $discount_price = floor($discount_price);

            $total_price = $total_price - $discount_price;
        } else {

            $total_price = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', '!=', 'no')->where('invoice_no', $req->invoice)->sum('subtotal');
        }
        $extra_charge = DB::table('charges')->get();
        $total_extra_charge = DB::table('charges')->sum('price');

        $total_price = $total_price + $total_extra_charge;
        $without_discount_price = $without_discount_price + $total_extra_charge;

        return view("trace_confirm", compact('carts', 'total_price', 'extra_charge', 'discount_price', 'without_discount_price'));
    }

    public function coupon_apply(Request $req)
    {
        $coupon_code = DB::table('coupons')->where('code', $req->code)->count();

        if ($coupon_code == 0) {
            session()->flash('wrong', 'Wrong Coupon Code !');
            return back();
        }
        $validate = DB::table('coupons')->where('code', $req->code)->value('validate');

        $today = date("Y-m-d");

        if ($validate < $today) {

            session()->flash('wrong', 'Expire Validation Date !');
            return back();
        }

        $data = array();

        $data['coupon_id'] = $req->code;

        $update_coupon = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->update($data);

        if ($update_coupon) {
            session()->flash('success', 'Apply discount code successfully !');

            return redirect('/cart');
        } else {
            session()->flash('wrong', 'Already applied this code !');

            return back();
        }
    }
}
