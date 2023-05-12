<?php

namespace App\Service;

use App\Repositories\Rates\RatesRepository;
use App\Service\Interface\RatesServiceInterface;

class RatesService implements RatesServiceInterface
{
    protected $rateRepository;

    public function __construct(RatesRepository $rateRepository)
    {
        $this->rateRepository = $rateRepository;
    }

    public function storeRate($productId, $userId, $starValue, $comments)
    {
        $this->rateRepository->addRate($userId, $productId, $starValue, $comments);

        $this->rateRepository->updateProductRate($productId, $starValue);

        return true;
    }

    public function updateRate($userId, $productId, $starValue, $comments)
    {
        $already_rate = $this->rateRepository->getRateCount($productId, $userId);

        if ($already_rate > 0) {
            // Nếu người dùng đã đánh giá sản phẩm rồi thì không cho đánh giá lại
            return false;
        }

        $result = $this->rateRepository->addRate($productId, $userId, $starValue, $comments);

        if ($result) {
            // Nếu lưu đánh giá thành công thì cập nhật lại điểm trung bình của sản phẩm
            $total_rate = $this->rateRepository->getTotalRate($productId);
            $total_voter = $this->rateRepository->getTotalVoter($productId);

            if ($total_voter > 0) {
                $per_rate = $total_rate / $total_voter;
            } else {
                $per_rate = 0;
            }

            $this->rateRepository->updateProductRate($productId, $per_rate);

            return true;
        }

        return false;
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

    public function deleteRate($id)
    {
        return $this->rateRepository->delete($id);
    }
}
