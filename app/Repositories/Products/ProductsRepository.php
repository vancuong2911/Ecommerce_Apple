<?php

namespace App\Repositories\Products;

use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Repositories\Products\ProductsRepositoryInterface;

class ProductsRepository extends BaseRepository implements ProductsRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
    }
    public function getProducts()
    {
        // Query Builder
        return $this->model->where('active', '0')->get();
    }

    public function showProductsRate($category)
    {
        $query = $this->model::leftJoin('rates', 'products.id', '=', 'rates.product_id')
            ->select('products.*', DB::raw('COALESCE(AVG(rates.star_value), 0) as average_rating'))
            ->where('active', '0')
            ->groupBy('products.id')
            ->orderByDesc('average_rating')
            ->get();
        if ($category !== '*') {
            $query->where('category', $category);
        }
        return $query;
    }

    public function showOneProductRate($id)
    {
        $product = $this->model::select('products.*', DB::raw('COALESCE(AVG(rates.star_value), 0) as average_rating'))
            ->leftJoin('rates', 'products.id', '=', 'rates.product_id')
            ->where('products.id', $id)
            ->groupBy('products.id')
            ->first();

        if (!$product) {
            // Xử lý khi không tìm thấy sản phẩm
            return abort(404);
        }

        return $product;
    }

    public function getProductsIsHot()
    {
        return $this->model->where('active', '0')->where('is_banner', '1')->get();
    }

    public function getCountProducts()
    {
        return $this->model->count();
    }

    public function getIphoneProducts()
    {
        return $this->model->where('category', 'iphone')->get();
    }

    public function getAppleWatchProducts()
    {
        return $this->model->where('category', 'apple watch')->get();
    }

    public function getDesktopProducts()
    {
        return $this->model->where('category', 'desktop')->get();
    }
}
