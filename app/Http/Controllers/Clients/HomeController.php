<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;

use App\Repositories\Products\ProductsRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Carts\CartsRepository;
use App\Service\CartsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    protected $productRepository;
    protected $cartService;
    protected $cartRepository;

    public function __construct(ProductsRepository $productRepository, CartsService $cartService, CartsRepository $cartRepository)
    {
        $this->productRepository = $productRepository;
        $this->cartService = $cartService;
        $this->cartRepository = $cartRepository;
    }
    public function index()
    {
        $menu = $this->productRepository->showProductsRate('*');

        // Get data of Product
        $about_us = DB::table('about_us')->get();
        $products = $this->productRepository->getProducts();
        $rates = $this->cartRepository->getRates();

        $iphoneProducts = $this->productRepository->showProductsRate('iphone');
        $appleWatchProducts = $this->productRepository->showProductsRate('apple_watch');
        $desktopProducts = $this->productRepository->showProductsRate('desktop');

        // Get quantity Cart
        $cart_amount = $this->cartService->getCartItemCount();

        return view("home", compact('menu', 'cart_amount', 'about_us', 'products', 'rates', 'iphoneProducts', 'appleWatchProducts', 'desktopProducts'));
    }

    // Contact ở Home
    public function contact_confirm(Request $request)
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

        $confirm_reservation = DB::table('reservations')->Insert($data);

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


        return redirect('/admin/home');
    }
}
