<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{

    public function order_incomplete()
    {
        $orders = DB::table('carts')->where('product_order', 'yes')
            ->groupBy('invoice_no')
            ->get();

        return view('admin.incomplete-orders', compact('orders'));
    }
    public function order_complete()
    {
        $orders = DB::table('carts')->where('product_order', 'delivery')
            ->groupBy('invoice_no')
            ->get();
        return view('admin.complete_orders', compact('orders'));
    }
    public function contact()
    {
        $contacts = DB::table('reservations')->get();

        return view('admin.contact', compact('contacts'));
    }

    public function invoice_approve(Request $req, $id)
    {

        $data = array();

        $data['product_order'] = "approve";

        // return $req->time;

        $time_set_up = strtotime($req->time);
        $time_set_up = date("F j, Y, G:i:sa", $time_set_up);

        // $req->time = $time_set_up;
        // return $req->time;
        $data['delivery_time'] = $req->time;


        $details = [
            'title' => 'Mail from MiniStore Admin',
            'body' => 'Your order approved by MiniStore.Your order Invoice no - ' . $id . ' & Delivery Time (approximately) - ' . $req->time,
        ];

        $products = DB::table('carts')->where('invoice_no', $id)->get();

        foreach ($products as $product) {


            $user_id = $product->user_id;
            $status = $product->product_order;
        }

        if ($status != "approve") {
            $details = [
                'title' => 'Mail from MiniStore Admin',
                'body' => 'Your order Invoice no - ' . $id . ' Delivery Time (approximately) - ' . $req->time,
            ];


            $user = DB::table('users')->where('id', $user_id)->first();

            Mail::to($user->email)->send(new \App\Mail\ApproveMail($details));


            $update = DB::table('carts')->where('invoice_no', $id)->Update($data);


            session()->flash('success', 'Order approved successfully !');
            return back();
        } else {

            $details = [
                'title' => 'Mail from MiniStore Admin',
                'body' => 'Your order approved by MiniStore.Your order Invoice no - ' . $id . ' & Delivery Remaining Time (approximately) - ' . $req->time,
            ];


            $user = DB::table('users')->where('id', $user_id)->first();

            Mail::to($user->email)->send(new \App\Mail\ApproveMail($details));


            $update = DB::table('carts')->where('invoice_no', $id)->Update($data);


            session()->flash('success', 'Order loaction updated successfully !');
            return redirect('/order/location');
        }
    }
    public function invoice_details($id)
    {

        $products = DB::table('carts')->where('invoice_no', $id)->get();
        $charges = DB::table('charges')->get();

        $total_price = DB::table('carts')->where('invoice_no', $id)->sum('subtotal');
        $wihout_discount_price = $total_price;
        foreach ($products as $product) {

            $coupon_code = $product->coupon_id;
        }
        $coupon_code_price = DB::table('coupons')->where('code', $coupon_code)->value('percentage');

        $coupon_code_price = floor($coupon_code_price);

        $discount_price = (($total_price * $coupon_code_price) / 100);
        $discount_price = floor($discount_price);

        $extra_charge = DB::table('charges')->get();
        $total_extra_charge = DB::table('charges')->sum('price');


        $total_price = $total_price - $discount_price;

        $total_price = $total_price + $total_extra_charge;
        $wihout_discount_price = $wihout_discount_price + $total_extra_charge;


        return view('admin.invoice_details', compact('total_price', 'extra_charge', 'total_extra_charge', 'discount_price', 'wihout_discount_price', 'products'));
    }
    public function invoice_cancel($id)
    {

        $data = array();

        $data['product_order'] = "cancel";


        $products = DB::table('carts')->where('invoice_no', $id)->get();

        foreach ($products as $product) {


            $user_id = $product->user_id;
            $pay_method = $product->pay_method;
            $status = $product->product_order;
        }

        if ($pay_method == "Online Payment") {

            $details = [
                'title' => 'Mail from MiniStore Admin',
                'body' => 'Sorry Sir.Your order cancelled by MiniStore for inevitable reason.You will get your money back within 8 working days..Your order Invoice no - ' . $id,
            ];
        } else {


            $details = [
                'title' => 'Mail from MiniStore Admin',
                'body' => 'Sorry Sir.Your order cancelled by MiniStore for inevitable reason.Your order Invoice no - ' . $id,
            ];
        }
        $user = DB::table('users')->where('id', $user_id)->first();

        Mail::to($user->email)->send(new \App\Mail\ApproveMail($details));


        $update = DB::table('carts')->where('invoice_no', $id)->Update($data);


        if ($status != "approve") {
            session()->flash('success', 'Order cancelled successfully !');
            return back();
        } else {

            session()->flash('success', 'Order cancelled successfully !');

            return redirect('/order/location');
        }
    }
    public function orders_process()
    {
        $orders = DB::table('carts')->where('product_order', 'approve')
            ->groupBy('invoice_no')
            ->get();


        return view('admin.process_order', compact('orders'));
    }
    public function orders_cancel()
    {
        $orders = DB::table('carts')->where('product_order', 'cancel')
            ->groupBy('invoice_no')
            ->get();


        return view('admin.cancel_order', compact('orders'));
    }
    public function invoice_complete($id)
    {

        $data = array();

        $data['product_order'] = "delivery";


        $details = [
            'title' => 'Mail from MiniStore Admin',
            'body' => 'Your order delivered by MiniStore.Your order Invoice no - ' . $id,
        ];

        $products = DB::table('carts')->where('invoice_no', $id)->get();

        foreach ($products as $product) {


            $user_id = $product->user_id;
            $status = $product->product_order;
        }




        $user = DB::table('users')->where('id', $user_id)->first();

        Mail::to($user->email)->send(new \App\Mail\ApproveMail($details));


        $update = DB::table('carts')->where('invoice_no', $id)->Update($data);


        session()->flash('success', 'Order delivered successfully !');
        return back();
    }
}
