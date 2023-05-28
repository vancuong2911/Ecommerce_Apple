<?php

namespace App\Http\Controllers\Admins\Products;

use App\Http\Controllers\Controller;
use App\Repositories\Products\ProductsRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeAdminController;

class ProductController extends Controller
{
    protected $productRepository;
    public function __construct(ProductsRepository $productRepository)
    {
        $this->productRepository = $productRepository;
        $this->middleware('auth');
    }
    public function index()
    {
        $total_products = $this->productRepository->getCountProducts();
        $fraction = $total_products % 3;
        $products = $this->productRepository->getProducts();
        $fraction_products = DB::table('products')->latest()->get();
        return view('admin.menu', compact('products', 'fraction', 'total_products', 'fraction_products'));
    }

    public function add_product()
    {
        return view('admin.add_product');
    }

    public function product_add_process(Request $req)
    {
        if ($req->price < 0 || $req->quantity < 0) {

            session()->flash('wrong', 'Input cannot be negative!');
            return back();
        }

        $this->validate(request(), [

            'image' => 'mimes:jpeg,jpg,png',
        ]);


        $uploadedfile = $req->file('image');
        $new_image = rand() . '.' . $uploadedfile->getClientOriginalExtension();
        $uploadedfile->move(public_path('/clients/images_upload/Products/'), $new_image);

        $data = array();
        $data['name'] = $req->name;
        $data['description'] = $req->description;
        $data['description_short'] = $req->description_short;
        $data['price'] = $req->price;
        $data['category'] = $req->category;
        $data['quantity'] = $req->quantity;
        $data['is_banner'] = $req->is_banner;
        $data['image'] = $new_image;
        $data['available'] = $req->available;
        if ($data['quantity'] == 0) {
            $data['available'] = "Out Of Stock";
        }
        if ($data['available'] == "Out Of Stock") {
            $data['quantity'] = 0;
        }

        $insert = DB::table('products')->Insert($data);


        session()->flash('success', 'product added successfully !');
        return back();
    }

    public function product_edit($id)
    {
        $products = DB::table('products')->where('id', $id)->get();

        return view('admin.product_edit', compact('products'));
    }
    public function product_edit_process(Request $req, $id)
    {
        if ($req->price < 0) {

            session()->flash('wrong', 'Negative Price value do not accept !');
            return back();
        }

        $data = array();
        $data['name'] = $req->name;
        $data['description'] = $req->description;
        $data['description_short'] = $req->description_short;
        $data['price'] = $req->price;
        $data['category'] = $req->category;
        $data['available'] = $req->available;
        $data['quantity'] = $req->quantity;
        $data['is_banner'] = $req->is_banner;

        if ($data['quantity'] == 0) {
            $data['available'] = "Out Of Stock";
        }

        if ($data['available'] == "Out Of Stock") {
            $data['quantity'] = 0;
        }

        if ($req->image != NULL) {

            $this->validate(request(), [

                'image' => 'mimes:jpeg,jpg,png',
            ]);

            $uploadedfile = $req->file('image');
            $new_image = rand() . '.' . $uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'), $new_image);

            $data['image'] = $new_image;
        }

        $update = DB::table('products')->where('id', $id)->Update($data);

        session()->flash('success', 'Product updated successfully !');
        return back();
    }
    public function product_delete_process($id)
    {
        $delete = DB::table('products')->where('id', $id)->delete();

        session()->flash('success', 'Product  deleted successfully !');
        return back();
    }
}
