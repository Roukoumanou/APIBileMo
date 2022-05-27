<?php
namespace App\Controller;

use App\Entity\Users;
use App\Entity\Customers;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Interfaces\CustomersUsersManagementInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CustomersUsersController extends AbstractController
{
    private CustomersUsersManagementInterface $iCustomers;

    private SerializerInterface $serializer;

    public function __construct(CustomersUsersManagementInterface $iCustomers, SerializerInterface $serializer)
    {
        $this->iCustomers = $iCustomers;
        $this->serializer = $serializer;
    }

    /**
     * @Get(path="/api/customer/{id}/users", name="customer_users")
     *
     * @param Customers $customer
     * @return Response
     */
    public function customersUsersList(Request $request, Customers $customer): Response
    {
        $page = (int) $request->query->get('page', 1);

        $data = $this->iCustomers->customersUsersList($customer, $page);

        $response = new Response($data, Response::HTTP_OK, ['Content-Type' => 'application/json']);
        
        return $response;
    }

    /**
     * @Get(path="/api/customer/{id}/user/{email}", name="customer_user_detail")
     *
     * @param Request $request
     * @return Response
     */
    public function customerUserShow(Request $request): Response
    {
        $data = $this->iCustomers->customerUserShow($request);

        $response = new Response($data, Response::HTTP_OK, ['Content-Type' => 'application/json']);
        
        return $response;
    }

    /**
     * @Post(path="/api/customer/{id}/users", name="add_user_by_customer")
     *
     * @param Request $request
     * @return Response
     */
    public function addUserLinkedCustomer(Request $request): Response
    {
        $user = $this->iCustomers->addUserLinkedCustomer($request);
        
        $response = new Response($user, Response::HTTP_CREATED, ['Content-Type' => 'application/json']);
        
        return $response;
    }

    /**
     * @Delete(path="/api/customer/{id}/user/{email}", name="delete_user_by_customer")
     *
     * @param Request $request
     * @return Response
     */
    public function deleteUserLinkedCustomer(Request $request): Response
    {
        $user = $this->iCustomers->deleteUserLinkedCustomer($request);
        
        $response = new Response($user, Response::HTTP_OK, ['Content-Type' => 'application/json']);
        
        return $response;
    }
}
