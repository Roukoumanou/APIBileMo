<?php
namespace App\Service\Interfaces;

use App\Entity\Products;

interface ProductsManagementInterface
{
    public function productsList(): array;

    public function productShow(Products $products): Products;
}
