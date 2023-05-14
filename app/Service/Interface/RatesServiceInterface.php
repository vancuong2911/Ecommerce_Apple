<?php

namespace App\Service\Interface;

interface RatesServiceInterface
{
    public function getRateValue($productId, $userId);

    public function getProduct($productId);

    public function storeRate($productId, $userId, $starValue, $comments);

    public function getTotalRate($productId);

    public function getTotalVoter($productId);

    public function getAllRates($productId);

    // public function createRate($userId, $productId, $starValue);

    // public function updateRate(Rate $rate, $starValue);

    public function deleteRate($id);
}
