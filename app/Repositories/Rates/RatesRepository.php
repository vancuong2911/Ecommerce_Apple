<?php

namespace App\Repositories\Rates;

use Illuminate\Support\Facades\DB;
use App\Repositories\Rates\RatesRepositoryInterface;
use App\Models\Rate;

class RatesRepository implements RatesRepositoryInterface
{
    public function getProduct($productId)
    {
        return DB::table('products')->where('id', $productId)->first();
    }

    public function getRateValue($productId, $userId)
    {
        $query = Rate::where('product_id', $productId);

        if ($userId !== null) {
            $query->where('user_id', $userId);
        }

        return $query->sum('star_value');
    }

    public function getTotalRate($productId)
    {
        return Rate::where('product_id', $productId)->sum('star_value');
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
        return Rate::where('product_id', $productId)->count();
    }

    public function getRate($productId)
    {
        return Rate::where('product_id', $productId)->first();
    }

    public function getAllRates($productId)
    {
        return Rate::where('product_id', $productId)->get();
    }

    public function getRateCount($productId, $userId)
    {
        return Rate::where('product_id', $productId)->where('user_id', $userId)->count();
    }

    public function getComments($productId, $userId)
    {
        return Rate::select('comments', 'created_at')
            ->where('product_id', $productId)
            ->where('user_id', $userId)
            ->whereNotNull('comments')->get();
    }

    public function addRate($userId, $productId,  $starValue, $comments)
    {
        $data = [
            'user_id' => $userId,
            'product_id' => $productId,
            'star_value' => $starValue,
            'comments' => $comments,
        ];
        $rate = Rate::create($data);
        return $rate;
    }

    public function updateProductRate($userId, $productId, $newRate, $comments)
    {
        $rate = Rate::where('product_id', $productId)
            ->where('user_id', $userId)
            ->first();

        if ($rate) {
            $rate->star_value = $newRate;
            $rate->comments = $comments;
            $rate->save();
            return $rate;
        }

        return null;
    }

    public function delete($id, $userId)
    {
        $rate = Rate::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if ($rate) {
            $rate->delete();
            return true;
        }
    }
}
