<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Repositories\Products\ProductsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Rates\RatesRepository;
use App\Service\RatesService;

class RateController extends Controller
{
    protected $rateRepository;
    protected $rateService;
    protected $productsRepository;

    public function __construct(RatesRepository $rateRepository, RatesService $rateService, ProductsRepository $productsRepository)
    {
        $this->rateRepository = $rateRepository;
        $this->rateService = $rateService;
        $this->productsRepository = $productsRepository;
    }

    public function rate($id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        Session::put('product_id', $id);

        $already_rate = $this->rateRepository->getRateCount($id, $user->id);
        $find_rate = $this->rateRepository->getRateValue($id, $user->id);
        $product = $this->productsRepository->showOneProductRate($id);


        $comments = $this->rateRepository->getComments($id, $user->id);

        if ($already_rate > 0) {
            return view('rate_view', compact('product', 'find_rate', 'already_rate', 'comments'));
        }

        return view('rate', compact('product', 'find_rate', 'already_rate', 'comments'));
    }

    public function store_rate(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }
        $validated = $request->validate([
            'star_value' => 'required',
            'comments' => 'required',
        ]);
        $product_id = Session::get('product_id');
        $star_value = $request->star_value;
        $comments = $request->comments;

        $already_rate = $this->rateRepository->getRateCount($product_id, $user->id);
        $is_update = false;

        if ($already_rate > 0) {
            // Nếu người dùng đã đánh giá sản phẩm rồi thì cho chỉnh sửa
            $is_update = true;
            // dd("Đã đánh giá, cho phép cập nhật");
        }
        // dd("Xử lý đánh giá");
        $result = $this->rateService->storeRate($user->id, $product_id, $star_value, $comments, $is_update);

        if (!$result) {
            session()->flash('wrong', 'Đăng bình luận thất bại!');
            return back();
        }
        return view('place_rate')->with('success', 'Đăng bình luận thành công!');

        // return view('place_rate')->with('error', 'Đăng bình luận thất bại!');
    }


    public function edit_rate($id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }
        // Số sao đánh giá của user
        $find_rate = $this->rateRepository->getRateValue($id, $user->id);
        // dd($find_rate);
        $product = $this->productsRepository->showOneProductRate($id);

        // Tổng lượt đánh giá của sản phẩm
        $total_rate = $this->rateRepository->getRateValue($id, null);
        // dd($total_rate);
        $total_voter = $this->rateRepository->getTotalVoter($id);

        if ($total_voter > 0) {
            $per_rate = $total_rate / $total_voter;
        } else {
            $per_rate = 0;
        }
        $per_rate = number_format($per_rate, 1);

        return view('rate', compact('product', 'find_rate', 'total_rate', 'total_voter', 'per_rate'));
    }

    public function delete_rate()
    {
        $product_id = Session::get('product_id');
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $rate = $this->rateRepository->getRate($product_id, $user->id);

        if ($rate) {
            $this->rateRepository->delete($rate->id, $user->id);
        }

        return view('delete_rate_confirm');
    }
}
