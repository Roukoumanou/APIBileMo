<?php
namespace App\Controller;

use App\Entity\Users;
use App\Entity\Customers;
use App\Repository\UsersRepository;
use App\Repository\CustomersRepository;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Interfaces\CustomersUsersManagementInterface;
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
     *
     * @param Customers $customer
     * @return Response
     */
    public function customersUsersList(Customers $customer): Response
    {
        $data = $this->iCustomers->customersUsersList($customer);

        return $this->json($data, 200, [], ['groups' => 'list_users']);
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

        return $this->json($data, 200, [], ['groups' => 'show_user']);
    }

    /**
     * @Post(path="/api/customer/{id}/users", name="add_user_by_customer")
     *
     * @param Request $request
     * @return Response
     */
    public function addUserLinkedCustomer(Request $request)
    {
        $user = $this->iCustomers->addUserLinkedCustomer($request);
        
        return $this->json($user, Response::HTTP_CREATED, [], ['groups' => 'show_user']);
    }

    /**
     * @Delete(path="/api/customer/{id}/user/{email}", name="delete_user_by_customer")
     *
     * @param Request $request
     * @return Response
     */
    public function DeleteUserLinkedCustomer(Request $request): Response
    {
        $user = $this->iCustomers->DeleteUserLinkedCustomer($request);
        
        return $this->json($user, Response::HTTP_MOVED_PERMANENTLY, [], ['groups' => 'list_users']);
    }
}
