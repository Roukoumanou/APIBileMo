<?php
namespace App\Controller;

use App\Entity\Customers;
use OpenApi\Annotations as Doc;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Security as NelmSecurity;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Interfaces\CustomersUsersManagementInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomersUsersController extends AbstractController
{
    private CustomersUsersManagementInterface $iCustomers;

    public function __construct(CustomersUsersManagementInterface $iCustomers)
    {
        $this->iCustomers = $iCustomers;
    }

    /**
     * @Get(path="/api/customer/{id}/users", name="customer_users")
     * @Security("is_granted('ROLE_CUSTOMER') and user.getUserIdentifier() === customer.getUserIdentifier()")
     * @Doc\Response(
     *      response=200,
     *      description="Get the list of all users linked to a customer."
     * )
     * @Doc\Parameter(
     *     name="id",
     *     in="path",
     *     description="This is the unique id of the customer making the request",
     *     @Doc\Schema(type="integer")
     * )
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
     * @Security("is_granted('ROLE_CUSTOMER') and user.getUserIdentifier() === customer.getUserIdentifier()")
     * @Doc\Response(
     *      response=200,
     *      description="Get a user's details related to a customer."
     * )
     * @Doc\Parameter(
     *     name="id",
     *     in="path",
     *     description="This is the unique id of the customer making the request",
     *     @Doc\Schema(type="integer")
     * ) 
     *
     * @param Customers $customer
     * @param Request $request
     * @return Response
     */
    public function customerUserShow(Customers $customer, Request $request): Response
    {
        $data = $this->iCustomers->customerUserShow($customer, $request);

        $response = new Response($data, Response::HTTP_OK, ['Content-Type' => 'application/json']);
        
        return $response;
    }

    /**
     * @Post(path="/api/customer/{id}/users", name="add_user_by_customer")
     * @Security("is_granted('ROLE_CUSTOMER') and user.getUserIdentifier() === customer.getUserIdentifier()")
     * @Doc\Response(
     *      response=201,
     *      description="Add a user linked to a customer."
     * )
     * @Doc\Parameter(
     *     name="id",
     *     in="path",
     *     description="This is the unique id of the customer making the request",
     *     @Doc\Schema(type="integer")
     * ) 
     *
     * @param Customers $customer
     * @param Request $request
     * @return Response
     */
    public function addUserLinkedCustomer(Customers $customer, Request $request): Response
    {
        $user = $this->iCustomers->addUserLinkedCustomer($customer, $request);
        
        $response = new Response($user, Response::HTTP_CREATED, ['Content-Type' => 'application/json']);
        
        return $response;
    }

    /**
     * @Delete(path="/api/customer/{id}/user/{email}", name="delete_user_by_customer")
     * @Security("is_granted('ROLE_CUSTOMER') and user.getUserIdentifier() === customer.getUserIdentifier()")
     * @Doc\Response(
     *      response=200,
     *      description="Delete a user linked to a customer."
     * )
     * @Doc\Parameter(
     *     name="id",
     *     in="path",
     *     description="This is the unique id of the customer making the request",
     *     @Doc\Schema(type="integer")
     * ) 
     *
     * @param Customers $customer
     * @param Request $request
     * @return Response
     */
    public function deleteUserLinkedCustomer(Customers $customer, Request $request): Response
    {
        $user = $this->iCustomers->deleteUserLinkedCustomer($customer, $request);
        
        $response = new Response($user, Response::HTTP_OK, ['Content-Type' => 'application/json']);
        
        return $response;
    }
}
