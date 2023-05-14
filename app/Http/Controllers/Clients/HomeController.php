<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Products\ProductsRepository;
use App\Http\Controllers\Controller;
use App\Service\CartsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    protected $productRepository;
    protected $cartService;

    public function __construct(ProductsRepository $productRepository, CartsService $cartService)
    {
        $this->productRepository = $productRepository;
        $this->cartService = $cartService;
    }
    public function index()
    {
        $menu = $this->productRepository->getMenu();

        // Get data of Product
        $iphone = $this->productRepository->getIphoneProducts('iphone', 0);
        $apple_watch = $this->productRepository->getAppleWatchProducts('apple watch', 1);
        $desktop = $this->productRepository->getDesktopProducts('desktop', 2);
        $about_us = $this->productRepository->getAboutUs();
        $banners = $this->productRepository->getBanners();
        $rates = $this->productRepository->getRates();

        // Get quantity Cart
        $cart_amount = $this->cartService->getCartItemCount();

        return view("home", compact('menu', 'iphone', 'apple_watch', 'desktop', 'cart_amount', 'about_us', 'banners', 'rates'));
    }

    // Admin
    public function redirects()
    {


        if (!Auth::user()) {

            return redirect()->route('login');
        }


        $menu = DB::table('products')->where('active', '0')->get();

        $iphone = DB::table('products')->where('catagory', 'iphone')->get();
        $apple_watch = DB::table('products')->where('catagory', 'apple watch')->get();
        $desktop = DB::table('products')->where('catagory', 'desktop')->get();


        if (Auth::user()) {

            $cart_amount = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->count();
        } else {

            $cart_amount = 0;
        }

        $about_us = DB::table('about_us')->get();
        $banners = DB::table('banners')->get();
        $rates = $this->productRepository->getRates();



        $usertype = Auth::user()->usertype;
        if ($usertype != '0') {

            $pending_order = DB::table('carts')->where('product_order', 'yes')->groupBy('invoice_no')->count();

            $processing_order = DB::table('carts')->where('product_order', 'approve')->groupBy('invoice_no')->count();

            $cancel_order = DB::table('carts')->where('product_order', 'cancel')->groupBy('invoice_no')->count();

            $complete_order = DB::table('carts')->where('product_order', 'delivery')->groupBy('invoice_no')->count();


            $total = DB::table('carts')->sum('subtotal');


            $cash_on_payment = DB::table('carts')->where('pay_method', 'Cash On Delivery')->sum('subtotal');


            $online_payment = $total - $cash_on_payment;


            $customer = DB::table('users')->where('usertype', '0')->count();


            $delivery_boy = DB::table('users')->where('usertype', '2')->count();


            $user = DB::table('users')->count();


            $admin = $user - ($customer + $delivery_boy);


            $rates = $this->productRepository->getAllRates();

            $product = array();


            foreach ($rates as $rate) {


                $product[$rate->product_id] = 0;
                $voter[$rate->product_id] = 0;
                $per_rate[$rate->product_id] = 0;
            }



            foreach ($rates as $rate) {


                $product[$rate->product_id] = $product[$rate->product_id] + $rate->star_value;


                $voter[$rate->product_id] = $voter[$rate->product_id] + 1;

                if ($voter[$rate->product_id] > 0) {

                    $per_rate[$rate->product_id] = $product[$rate->product_id] / $voter[$rate->product_id];
                } else {


                    $per_rate[$rate->product_id] = $product[$rate->product_id];
                }

                $per_rate[$rate->product_id] = number_format($per_rate[$rate->product_id], 1);
            }

            $copy_product = $per_rate;

            arsort($per_rate);


            // return $per_rate;


            $product_get = array();


            foreach ($per_rate as $prod) {

                $index_search = array_search($prod, $copy_product);

                $product_get = DB::table('products')->where('id', $index_search)->get();


                // return $product_get;





            }


            $carts = DB::table('carts')->where('product_order', '!=', 'no')->where('product_order', '!=', 'cancel')->get();

            $cart = array();


            foreach ($carts as $cart) {


                $product_cart[$cart->product_id] = 0;
            }



            foreach ($carts as $cart) {


                $product_cart[$cart->product_id] = $product_cart[$cart->product_id] + $cart->quantity;
            }

            $copy_cart = $product_cart;

            arsort($product_cart);



            return view('admin.dashboard', compact('pending_order', 'product_cart', 'copy_cart', 'total', 'copy_product', 'per_rate', 'product', 'cash_on_payment', 'online_payment', 'customer', 'delivery_boy', 'admin', 'processing_order', 'cancel_order', 'complete_order', 'rates'));
        } else {
            return view("home", compact('menu', 'iphone', 'apple_watch', 'desktop', 'cart_amount', 'about_us', 'banners', 'rates'));
        }
    }

    // Contact ở Home
    public function reservation_confirm(Request $request)
    {

        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $message = $request->message;

        $data = array();

        $data['name'] = $name;
        $data['email'] = $email;
        $data['phone'] = $phone;
        $data['message'] = $message;

        $data["title"] = "Mail from Ministore Admin";
        $data["body"] = "We will respond to your comments as soon as possible, thanks!";

        Mail::send('mails.Reserve', $data, function ($message) use ($data, $email) {
            $message->to($email, $email)
                ->subject($data["title"]);
        });

        return view('Reserve_order');
    }


    public function register(Request $req)
    {

        $data = array();
        $data['name'] = $req->name;
        $data['phone'] = $req->phone;
        $data['email'] = $req->email;
        $data['password'] = Hash::make($req->password);

        $email = DB::table('users')->where('email', $req->email)->count();


        if ($email > 0) {

            session()->flash('wrong', 'Email already registered !');
            return back();
        }

        $phone = DB::table('users')->where('phone', $req->phone)->count();


        if ($phone > 0) {

            session()->flash('wrong', 'Phone already registered !');
            return back();
        }
        if (strlen($req->password) < 8) {

            session()->flash('wrong', 'Password lenght at least 8 words!');
            return back();
        }

        if ($req->password != $req->password_confirmation) {


            session()->flash('wrong', 'Password do not match !');
            return back();
        }

        $insert = DB::table('users')->Insert($data);


        return redirect('/redirects');
    }
}
