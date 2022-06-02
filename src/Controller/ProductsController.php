<?php 
namespace App\Controller;

use App\Entity\Products;
use OpenApi\Annotations as Doc;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Interfaces\ProductsManagementInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProductsController extends AbstractController
{
    private ProductsManagementInterface $iProducts;

    public function __construct(ProductsManagementInterface $iProducts)
    {
        $this->iProducts = $iProducts;
    }

    /**
     * @Get(path="/api/products", name="products")
     * @IsGranted("ROLE_CUSTOMER")
     * @Doc\Response(
     *      response=200,
     *      description="Get the list of all BileMo products."
     * )
     *
     * @param Request $request
     * @return Response
     */
    public function productsList(Request $request): Response
    {
        $page = (int) $request->query->get('page', 1);

        $data = $this->iProducts->productsList($page);
        
        $response = new Response($data, 200, ['Content-Type' => 'application/json']);

        return $response;
    }

    /**
     * @Get(path="/api/products/{id}", name="show_product")
     * @IsGranted("ROLE_CUSTOMER")
     * @Doc\Response(
     *      response=200,
     *      description="Get details of a BileMo product."
     * )
     * @Doc\Parameter(
     *     name="id",
     *     in="path",
     *     description="This is the unique id of the product we want to obtain.",
     *     @Doc\Schema(type="integer")
     * )
     *
     * @param Products $product
     */
    public function productShow(Products $product): Response
    {
        $data = $this->iProducts->productShow($product);

        $response = new Response($data, 200, ['Content-Type' => 'application/json']);
        
        return $response;

    }
}
