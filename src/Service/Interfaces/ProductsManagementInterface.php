<?php
namespace App\Service\Interfaces;

use App\Entity\Products;

interface ProductsManagementInterface
{
    public function productsList(int $page = 1): array;

    public function productShow(Products $products): Products;
}
