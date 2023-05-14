<?php

namespace App\Repositories\Rates;

interface RatesRepositoryInterface
{
    public function getRateValue($productId, $userId);

    public function getProduct($productId);

    public function getTotalRate($productId);

    public function getTotalVoter($productId);

    public function getAllRates($productId);

    public function getRateCount($productId, $userId);

    public function getComments($productId);

    public function addRate($productId, $userId, $starValue, $comments);

    public function updateProductRate($productId, $newRate);

    // public function create($data);

    // public function update($id, $data);

    public function delete($id);
}
