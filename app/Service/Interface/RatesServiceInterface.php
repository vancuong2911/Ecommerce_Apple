<?php

namespace App\Service\Interface;

interface RatesServiceInterface
{
    public function storeRate($userId, $productId, $starValue, $comments, $isUpdate = false);

    public function getRateValue($productId, $userId);

    public function getProduct($productId);

    public function getTotalRate($productId);

    public function calculateAndSaveAverageRating($productId);

    public function getTotalVoter($productId);

    public function getRate($productId);

    public function getAllRates($productId);

    public function deleteRate($id, $userId);
}
