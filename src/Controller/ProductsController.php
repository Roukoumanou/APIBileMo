<?php 
namespace App\Controller;

use App\Entity\Products;
use App\Service\Interfaces\ProductsManagementInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends AbstractController
{
    private ProductsManagementInterface $iProducts;

    public function __construct(ProductsManagementInterface $iProducts)
    {
        $this->$iProducts = $iProducts;
    }

    /**
     * @Get(path="/api/products", name="products")
     * @View
     *
     * @return Response
     */
    public function productsList(): Response
    {
        $datas = $this->iProducts->productsList();

        return $this->json($datas);
    }

    /**
     * @Get(path="/api/products/{id}", name="show_product")
     * @View
     *
     * @param Products $product
     */
    public function productShow(Products $product): Response
    {
        $product = $this->iProducts->productShow($product);
        return $this->json($product);
    }
}
