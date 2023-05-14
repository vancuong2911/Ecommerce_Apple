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

    public function storeRate($userId, $productId, $starValue, $comments, $isUpdate = false)
    {
        $already_rate = $this->rateRepository->getRateCount($productId, $userId);

        if ($isUpdate && $already_rate > 0) {
            $rate = $this->rateRepository->getUserRate($productId, $userId);
            $this->rateRepository->updateProductRate($productId, $starValue);
            $this->rateRepository->updateComment($rate->product_id, $comments);
            $result = true;
        } elseif (!$isUpdate && $already_rate == 0) {
            $this->rateRepository->addRate($userId, $productId, $starValue, $comments);
            $result = true;
        } else {
            $result = false;
        }

        return $result;
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
