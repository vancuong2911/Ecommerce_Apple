<?php

namespace App\Service;

use App\Repositories\Rates\RatesRepository;
use App\Service\Interface\RatesServiceInterface;
use App\Models\Rate;
use App\Models\Product;

class RatesService implements RatesServiceInterface
{
    protected $rateRepository;

    public function __construct(RatesRepository $rateRepository)
    {
        $this->rateRepository = $rateRepository;
    }

    public function storeRate($userId, $productId, $starValue, $comments, $isUpdate = false)
    {
        $already_rate = $this->rateRepository->getRateCount($productId, $userId);
        // isUpdate sai và người dùng đã đánh giá
        if ($isUpdate && $already_rate > 0) {
            $this->rateRepository->updateProductRate($userId, $productId, $starValue, $comments);
            $result = true;
        } elseif (!$isUpdate && $already_rate == 0) {
            $this->rateRepository->addRate($userId, $productId, $starValue, $comments);
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    public function calculateAndSaveAverageRating($productId)
    {
        // Lấy tổng số sao và số người đánh giá
        $totalRate = Rate::where('product_id', $productId)->sum('star_value');
        $totalVoter = Rate::where('product_id', $productId)->count();

        // // Tính số sao trung bình
        $averageRate = ($totalVoter > 0) ? $totalRate / $totalVoter : 0;
        Rate::where('product_id', $productId)->update(['average_rating' => $averageRate]);
    }


    public function getRateValue($productId, $userId)
    {
        return $this->rateRepository->getRateValue($productId, $userId);
    }

    public function getProduct($productId)
    {
        return $this->rateRepository->getProduct($productId);
    }

    public function getTotalRate($productId)
    {
        return $this->rateRepository->getTotalRate($productId);
    }

    public function getTotalVoter($productId)
    {
        return $this->rateRepository->getTotalVoter($productId);
    }

    public function getRate($productId)
    {
        return $this->rateRepository->getRate($productId);
    }

    public function getAllRates($productId)
    {
        return $this->rateRepository->getAllRates($productId);
    }

    public function deleteRate($id, $userId)
    {
        return $this->rateRepository->delete($id, $userId);
    }
}
