<?php 
namespace App\Controller;

use App\Entity\Products;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Interfaces\ProductsManagementInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProductsController extends AbstractController
{
    private ProductsManagementInterface $iProducts;

    public function __construct(ProductsManagementInterface $iProducts)
    {
        $this->iProducts = $iProducts;
    }

    /**
     * @Get(path="/api/products", name="products")
     *
     * @param Request $request
     * @return Response
     */
    public function productsList(Request $request): Response
    {
        $page = (int) $request->query->get('page', 1);

        $products = $this->iProducts->productsList($page);


        return $this->json($products, 200, [], ['groups' => 'list_products']);
    }

    /**
     * @Get(path="/api/products/{id}", name="show_product")
     *
     * @param Products $product
     */
    public function productShow(Products $product): Response
    {
        $product = $this->iProducts->productShow($product);
        return $this->json($product, 200, [], ['groups' => 'show_product']);
    }
}
