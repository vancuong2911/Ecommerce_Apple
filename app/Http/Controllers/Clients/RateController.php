<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Rates\RatesRepository;
use App\Service\RatesService;

class RateController extends Controller
{
    protected $rateRepository;
    protected $rateService;

    public function __construct(RatesRepository $rateRepository, RatesService $rateService)
    {
        $this->rateRepository = $rateRepository;
        $this->rateService = $rateService;
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
        $products = $this->rateRepository->getProduct($id);
        $total_rate = $this->rateRepository->getTotalRate($id);
        $total_voter = $this->rateRepository->getTotalVoter($id);
        if ($total_voter > 0) {
            $per_rate = $total_rate / $total_voter;
        } else {
            $per_rate = 0;
        }

        $per_rate = number_format($per_rate, 1);

        $comments = $this->rateRepository->getComments($id);

        if ($already_rate > 0) {
            return view('rate_view', compact('products', 'find_rate', 'already_rate', 'total_rate', 'total_voter', 'per_rate', 'comments'));
        }

        return view('rate', compact('products', 'find_rate', 'already_rate', 'total_rate', 'total_voter', 'per_rate', 'comments'));
    }

    public function store_rate(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

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

        if ($result) {
            return view('place_rate')->with('success', 'Đăng bình luận thành công!');
        }

        return view('place_rate')->with('error', 'Đăng bình luận thất bại!');
    }


    public function edit_rate($id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $find_rate = $this->rateRepository->getRateValue($id, $user->id);
        $products = $this->rateRepository->getProduct($id);
        $total_rate = $this->rateRepository->getTotalRate($id);
        $total_voter = $this->rateRepository->getTotalVoter($id);

        if ($total_voter > 0) {
            $per_rate = $total_rate / $total_voter;
        } else {
            $per_rate = 0;
        }
        $per_rate = number_format($per_rate, 1);

        return view('rate', compact('products', 'find_rate', 'total_rate', 'total_voter', 'per_rate'));
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
            $this->rateRepository->delete($rate->id);
        }

        return view('delete_rate_confirm');
    }

    // public function top_rated()
    // {

    //     $products = DB::table('rates')
    //         ->get();


    //     $data = array();

    //     foreach ($products as $product) {


    //         $data[$product->product_id] = 0;
    //     }

    //     $max_product = array();

    //     foreach ($products as $product) {


    //         $data[$product->product_id] = $data[$product->product_id] + $product->star_value;
    //     }

    //     rsort($data);



    //     dd($data);
    // }

    // public function rate($id)
    // {

    //     if (!Auth::user()) {

    //         return redirect()->route('login');
    //     }

    //     $already_rate = DB::table('rates')->where('product_id', $id)->where('user_id', Auth::user()->id)
    //         ->count();


    //     $find_rate = DB::table('rates')->where('product_id', $id)->where('user_id', Auth::user()->id)
    //         ->value('star_value');


    //     $products = DB::table('products')->where('id', $id)->first();


    //     $total_rate = DB::table('rates')->where('product_id', $id)
    //         ->sum('star_value');


    //     $total_voter = DB::table('rates')->where('product_id', $id)
    //         ->count();

    //     if ($total_voter > 0) {

    //         $per_rate = $total_rate / $total_voter;
    //     } else {

    //         $per_rate = 0;
    //     }

    //     $per_rate = number_format($per_rate, 1);

    //     $comments = DB::table('rates')->where('product_id', $id)->get();

    //     if ($already_rate > 0) {


    //         return view('rate_view', compact('products', 'find_rate', 'already_rate', 'total_rate', 'total_voter', 'per_rate', 'comments'));
    //     }




    //     return view('rate', compact('products', 'find_rate', 'already_rate', 'total_rate', 'total_voter', 'per_rate', 'comments'));
    // }

    // public function store_rate(Request $request)
    // {
    //     $product_id = Session::get('product_id');
    //     $user_id = Auth::user()->id;
    //     $star_value = $request->star_value;
    //     $comments = $request->comments;

    //     $data = [
    //         'user_id' => $user_id,
    //         'product_id' => $product_id,
    //         'star_value' => $star_value,
    //         'comments' => $comments,
    //     ];

    //     $rate = DB::table('rates')->where('product_id', $product_id)->where('user_id', $user_id)->count();

    //     if ($rate > 0) {

    //         $edit_rate = DB::table('rates')->where('product_id', $product_id)->where('user_id', $user_id)->update($data);
    //     } else {

    //         $add = DB::table('rates')->Insert($data);
    //     }
    //     // Trả về view khi đăng bình luận thành công
    //     return view('place_rate')->with('success', 'Đăng bình luận thành công!');
    // }

    // public function delete_rate()
    // {

    //     $product_id = Session::get('product_id');
    //     $user_id = Auth::user()->id;
    //     $rate = DB::table('rates')->where('product_id', $product_id)->where('user_id', $user_id)->delete();

    //     return view('delete_rate_confirm');
    // }

    // public function edit_rate($id)
    // {


    //     if (!Auth::user()) {

    //         return redirect()->route('login');
    //     }




    //     $find_rate = DB::table('rates')->where('product_id', $id)->where('user_id', Auth::user()->id)
    //         ->value('star_value');


    //     $products = DB::table('products')->where('id', $id)->first();


    //     $total_rate = DB::table('rates')->where('product_id', $id)
    //         ->sum('star_value');


    //     $total_voter = DB::table('rates')->where('product_id', $id)
    //         ->count();

    //     if ($total_voter > 0) {

    //         $per_rate = $total_rate / $total_voter;
    //     } else {

    //         $per_rate = 0;
    //     }

    //     $per_rate = number_format($per_rate, 1);




    //     return view('rate', compact('products', 'find_rate', 'total_rate', 'total_voter', 'per_rate'));
    // }
}
