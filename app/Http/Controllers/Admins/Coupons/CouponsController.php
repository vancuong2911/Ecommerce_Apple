<?php

namespace App\Http\Controllers\Admins\Coupons;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CouponProduct;
use App\Models\Product;
use App\Models\Coupon;
use App\Repositories\Products\ProductsRepository;

class CouponsController extends Controller
{
    protected $productRepository;

    public function __construct(ProductsRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function coupon_show()
    {
        $coupons = Coupon::with('couponProduct')->get();

        return view('admin.coupons', compact('coupons'));
    }
    public function add_coupon()
    {
        $products = $this->productRepository->getProducts();
        return view('admin.add_coupon', ['products' => $products]);
    }

    public function add_coupon_process(Request $request)
    {
        // $req->validate([
        //     'name' => 'required',
        //     'details' => 'required',
        //     'discount_percentage' => 'required',
        //     'code' => 'required',
        //     'product_id' => 'required',
        //     'validation_date' => 'required',
        // ]);

        $coupon = Coupon::create([
            'name' => $request->name,
            'details' => $request->details,
            'percentage' => $request->discount_percentage,
            'code' => $request->code,
        ]);

        $product = Product::findOrFail($request->product_id);

        CouponProduct::create([
            'coupon_id' => $coupon->id,
            'product_id' => $product->id,
            'validate' => $request->validation_date,
        ]);

        session()->flash('success', 'Coupon added successfully!');
        return back();
    }

    public function delete_coupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->products()->detach(); // Xóa các liên kết trong bảng coupon_product
        $coupon->delete(); // Xóa mã giảm giá từ bảng coupons

        session()->flash('success', 'Coupon deleted successfully!');
        return redirect()->back();
    }

    public function edit_coupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon_product = CouponProduct::where('coupon_id', $coupon->id)->first();
        $products = Product::all();

        return view('admin.edit_coupon', compact('coupon', 'products', 'coupon_product'));
    }
    public function edit_coupon_process($id, Request $request)
    {
        $coupon = Coupon::findOrFail($id);

        $coupon->name = $request->name;
        $coupon->details = $request->details;
        $coupon->percentage = $request->discount_percentage;
        $coupon->code = $request->code;
        $coupon->validate = $request->validation_date;

        // Lưu dữ liệu vào bảng coupon
        $coupon->save();

        // Đồng bộ danh sách sản phẩm trong bảng trung gian coupon_product
        $coupon->products()->sync([$request->product_id]);

        session()->flash('success', 'Coupon updated successfully!');
        return back();
    }
}
