<?php

namespace App\Repositories\Carts;

use App\Repository\RepositoryInterface;

interface CartsRepositoryInterface
{
    public function getCartById($id);
    public function getProductbyUserId();
    public function updateCartQuantity($productId, $userId, $quantity, $productPrice);

    public function getRates();

    public function getAllRates();

    public function createCart($productId, $userId, $quantity, $productPrice, $product);

    public function getCartQuantity($productId, $userId);

    public function getCartByUserId($userId);

    public function getCartsAmountByUserId($userId);

    public function getCouponCodeByUserId($userId);

    public function getDiscountPriceByCouponCode($couponCode, $totalPrice);

    public function getTotalPriceByUserId($userId);

    public function getCouponDataByCode($couponCode);

    public function applyCouponDiscount($totalPrice, $couponData);

    public function couponDiscountPrice($totalPrice, $couponData);

    public function getWithoutDiscountPriceByUserId(int $userId): int;

    public function getExtraCharges();

    public function getTotalExtraCharge();

    public function getPendingOrderCount(): int;

    public function getProcessingOrderCount(): int;

    public function getCancelledOrderCount(): int;

    public function getCompleteOrderCount(): int;

    public function getTotal(): float;

    public function getCashOnDeliveryTotal(): float;

    public function getOnlinePaymentTotal(): float;
}
