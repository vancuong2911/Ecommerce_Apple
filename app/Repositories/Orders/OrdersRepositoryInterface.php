<?php

namespace App\Repositories\Orders;

interface OrdersRepositoryInterface
{
    public function createOrderData($address);

    public function calculateTotalPrice($userId);

    public function applyCoupon($userId);
}
