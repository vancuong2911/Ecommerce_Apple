<?php

namespace App\Service\Interface;

interface RatesServiceInterface
{
    public function getRateValue($productId, $userId);

    public function getProduct($productId);

    public function storeRate($productId, $userId, $starValue, $comments);

    public function updateRate($userId, $productId, $starValue, $comments);

    public function getTotalRate($productId);

    public function getTotalVoter($productId);

    public function getAllRates($productId);

    public function deleteRate($id);
}
