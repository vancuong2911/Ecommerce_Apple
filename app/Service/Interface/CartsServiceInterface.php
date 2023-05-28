<?php

namespace App\Service\Interface;

interface CartsServiceInterface
{
    public function store($request, $id);

    public function destroy($id);

    public function getCartData($userId);

    public function getCart();

    public function getCartItemCount();
}
