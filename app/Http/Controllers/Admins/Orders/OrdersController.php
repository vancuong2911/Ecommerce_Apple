<?php

namespace App\Http\Controllers\Admins\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Library\SslCommerz\SslCommerzNotification;


class OrdersController extends Controller
{
    public function index(Request $request)
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.


        $total = Session::get('total');


        $invoice = Session::get('invoice');


        $post_data = array();
        $post_data['total_amount'] = $total; # You cant not pay less than 10
        $post_data['currency'] = "USD";
        $post_data['tran_id'] = $invoice; // tran_id must be unique


        Session::put('address', $request->address);




        # CUSTOMER INFORMATION
        $post_data['cus_name'] = Auth::user()->name;
        $post_data['cus_email'] = Auth::user()->email;
        $post_data['cus_add1'] = $post_data['cus_add1'];
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "VietNam";
        $post_data['cus_phone'] = Auth::user()->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "VietNam";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        Session::put('address', $post_data['cus_add1']);

        #Before  going to initiate the payment order status need to insert or update as Pending.
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

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }
    public function order_incomplete()
    {
        // dd($orders);

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
            return redirect('/orders/process');
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
