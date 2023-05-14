<?php

namespace App\Repositories\Orders;

use Illuminate\Support\Facades\DB;

class OrdersRepository implements OrdersRepositoryInterface
{
    public function createOrderData($address)
    {
        $data = array();
        $invoice = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 8);

        $data['shipping_address'] = $address;
        $data['product_order'] = "yes";
        $data['invoice_no'] = $invoice;
        $data['pay_method'] = "Cash On Delivery";
        $data['delivery_time'] = "3 hours";
        $data['purchase_date'] = date("Y-m-d");

        return array('invoice' => $invoice, 'data' => $data);
    }

    public function calculateTotalPrice($userId)
    {
        $total = DB::table('carts')->where('user_id', $userId)->where('product_order', 'no')->sum('subtotal');

        $totalExtraCharge = DB::table('charges')->sum('price');
        $total += $totalExtraCharge;
        // dd($total);
        return $total;
    }

    public function applyCoupon($userId)
    {
        $couponCode = DB::table('carts')->where('user_id', $userId)->where('product_order', 'no')->value('coupon_id');

        if ($couponCode) {
            $couponPrice = DB::table('coupons')->where('code', $couponCode)->value('percentage');
            $couponPrice = floor($couponPrice);

            $total = DB::table('carts')->where('user_id', $userId)->where('product_order', 'no')->sum('subtotal');

            $discountPrice = (($total * $couponPrice) / 100);
            $discountPrice = floor($discountPrice);

            DB::table('carts')->where('user_id', $userId)->where('product_order', 'no')->update([
                'discount_price' => $discountPrice,
                'total_price' => $total - $discountPrice
            ]);
        }
    }
}
