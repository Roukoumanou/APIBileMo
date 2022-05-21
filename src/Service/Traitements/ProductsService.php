<?php
namespace App\Service\Traitements;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use App\Service\Interfaces\ProductsManagementInterface;

class ProductsService implements ProductsManagementInterface
{
    private ProductsRepository $productsRepository;

    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }
    
    public function productsList(): array
    {
        return $this->productsRepository->findAll();
    }

    public function productShow(Products $products): Products
    {
        return $products;
    }
}
