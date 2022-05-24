<?php
namespace App\Service\Traitements;

use App\Entity\Products;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use App\Repository\ProductsRepository;
use App\Service\Interfaces\ProductsManagementInterface;

class ProductsService implements ProductsManagementInterface
{
    public const MAX_PER_PAGE = 5;

    private ProductsRepository $productsRepository;

    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }
    
    public function productsList(int $page = 1): array
    {
        $products = $this->productsRepository->findAll();
        $adapter = new ArrayAdapter($products);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage($adapter, $page, self::MAX_PER_PAGE);
        $currentPageResults = $pagerfanta->getCurrentPageResults();

        return (array) $currentPageResults;
    }

    public function productShow(Products $products): Products
    {
        return $products;
    }
}
