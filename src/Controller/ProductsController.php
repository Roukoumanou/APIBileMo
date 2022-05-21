<?php 
namespace App\Controller;

use App\Entity\Products;
use App\Service\Interfaces\ProductsManagementInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

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
     * @return Response
     */
    public function productsList(): Response
    {
        $datas = $this->iProducts->productsList();

        return $this->json($datas, 200, [], ['groups' => 'list_products']);
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
