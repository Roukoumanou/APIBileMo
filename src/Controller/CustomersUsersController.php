<?php
namespace App\Controller;

use App\Entity\Customers;
use OpenApi\Annotations as Doc;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use Nelmio\ApiDocBundle\Annotation\Security as NelSecurity;
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
     * @Get(path="/api/customers/{id}/users", name="customer_users")
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
     * @NelSecurity(name="Bearer")
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
     * @Get(path="/api/customers/{id}/users/{email}", name="customer_user_detail")
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
     * @NelSecurity(name="Bearer")
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
     * @Post(path="/api/customers/{id}/users", name="add_user_by_customer")
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
     * @Doc\RequestBody(
     *      description= "You will need to fill in the fields: first_name, last_name, email and a password for your user",
     *      required= true,
     *      @Doc\JsonContent(
     *          example={
     *              "first_name": "firstName",
     *              "last_name": "lastName",
     *              "email": "bilmo@gmail.com",
     *              "password": "password"
     *          },
     *          @Doc\Schema(
     *              type="object",
     *              @Doc\Property(property="first_name", required=true, description="Add first name", type="string"),
     *              @Doc\Property(property="last_name", required=true, description="Add last name", type="string"),
     *              @Doc\Property(property="email", required=true, description="add email", type="string"),
     *              @Doc\Property(property="password", required=true, description="add password", type="string")
     *          )
     *      )
     * )
     * @NelSecurity(name="Bearer")
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
     * @Delete(path="/api/customers/{id}/users/{email}", name="delete_user_by_customer")
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
     * @NelSecurity(name="Bearer")
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
