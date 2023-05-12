<?php
namespace App\Repository\Carts;

use App\Repository\RepositoryInterface;

interface CartsRepositoryInterface extends RepositoryInterface
{
    public function getModel();
    public function addProductToCart($product);
    public function updateProductInCart($product);
    public function removeProductFromCart($product);
    public function getCart();
}
