<?php
namespace App\Service\Traitements;

use App\Entity\Products;
use Pagerfanta\Pagerfanta;
use Hateoas\Configuration\Route;
use Pagerfanta\Adapter\ArrayAdapter;
use App\Repository\ProductsRepository;
use JMS\Serializer\SerializerInterface;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\Factory\PagerfantaFactory;
use App\Service\Interfaces\ProductsManagementInterface;

class ProductsService implements ProductsManagementInterface
{
    public const MAX_PER_PAGE = 5;

    private ProductsRepository $productsRepository;

    private SerializerInterface $serializer;

    public function __construct(ProductsRepository $productsRepository, SerializerInterface $serializer)
    {
        $this->productsRepository = $productsRepository;
        $this->serializer = $serializer;
    }
    
    public function productsList(int $page = 1): string
    {
        $products = $this->productsRepository->findAll();

        $adapter = new ArrayAdapter($products);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage($adapter, $page, self::MAX_PER_PAGE);
        $currentPageResults = $pagerfanta->getCurrentPageResults();

        $pagerfantaFactory   = new PagerfantaFactory(); // you can pass the page and limit parameters name
        $paginatedCollection = $pagerfantaFactory->createRepresentation(
            $pagerfanta,
            new Route('products', array()),
            new CollectionRepresentation($currentPageResults)
        );

        $data = $this->serializer->serialize($paginatedCollection, 'json');

        return (string) $data;
    }

    public function productShow(Products $product): string
    {
        $data = $this->serializer->serialize($product, 'json');

        return (string) $data;
    }
}
