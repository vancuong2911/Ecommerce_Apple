<?php

namespace App\Http\Controllers\Admins\Products;

use App\Http\Controllers\Controller;
use App\Repositories\Products\ProductsRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepository;
    public function __construct(ProductsRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function index()
    {
        $total_products = $this->productRepository->getCountProducts();
        $fraction = $total_products % 3;
        $products = $this->productRepository->getMenu();
        $fraction_products = DB::table('products')->latest()->get();

        return view('admin.menu', compact('products', 'fraction', 'total_products', 'fraction_products'));
    }

    public function add_product()
    {
        return view('admin.add_product');
    }

    public function product_add_process(Request $req)
    {


        if ($req->price < 0) {

            session()->flash('wrong', 'Negative Price value do not accept !');
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
        $data['price'] = $req->price;
        $data['catagory'] = $req->catagory;
        $data['available'] = $req->available;
        $data['image'] = $new_image;

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
        $data['price'] = $req->price;
        $data['catagory'] = $req->catagory;
        $data['available'] = $req->available;

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
