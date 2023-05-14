<?php

namespace App\Repositories\Rates;

use Illuminate\Support\Facades\DB;
use App\Repositories\Rates\RatesRepositoryInterface;

class RatesRepository implements RatesRepositoryInterface
{
    public function getProduct($productId)
    {
        return DB::table('products')->where('id', $productId)->first();
    }

    public function getRateValue($productId, $userId)
    {
        return DB::table('rates')->where('product_id', $productId)->where('user_id', $userId)->value('star_value');
    }

    public function getTotalRate($productId)
    {
        return DB::table('rates')->where('product_id', $productId)->sum('star_value');
    }

    public function getUserRate($productId, $userId)
    {
        $rate = DB::table('rates')
            ->where('product_id', $productId)
            ->where('user_id', $userId)
            ->first();

        return $rate;
    }

    public function getTotalVoter($productId)
    {
        return DB::table('rates')->where('product_id', $productId)->count();
    }

    public function getRate($productId)
    {
        return DB::table('rates')->where('product_id', $productId)->first();
    }

    public function getAllRates($productId)
    {
        return DB::table('rates')->where('product_id', $productId)->get();
    }

    public function getRateCount($productId, $userId)
    {
        return DB::table('rates')->where('product_id', $productId)->where('user_id', $userId)->count();
    }

    public function getComments($productId)
    {
        return DB::table('rates')->select('comments', 'created_at')->where('product_id', $productId)->whereNotNull('comments')->get();
    }

    public function addRate($userId, $productId,  $starValue, $comments)
    {
        $data = [
            'user_id' => $userId,
            'product_id' => $productId,
            'star_value' => $starValue,
            'comments' => $comments,
        ];

        return DB::table('rates')->insert($data);
    }

    public function updateProductRate($productId, $newRate)
    {
        return DB::table('rates')->where('product_id', $productId)->update(['star_value' => $newRate]);
    }

    public function updateComment($productId, $comments)
    {
        $product = $this->getProduct($productId);
        $rate = DB::table('rates')->where('product_id', $product->id)->first();

        if ($rate && $rate->comments != $comments) {
            return DB::table('rates')->where('product_id', $product->id)->update(['comments' => $comments]);
        }

        return false;
    }

    public function delete($id)
    {
        return DB::table('rates')->where('id', $id)->delete();
    }
}
