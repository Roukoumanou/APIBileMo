<?php
namespace App\Service\Interfaces;

use App\Entity\Customers;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Request;

interface CustomersUsersManagementInterface
{
    public function customersUsersList(Customers $customer, int $page): array;

    public function customerUserShow(Request $request): ?Users;

    public function addUserLinkedCustomer(Request $request);

    public function DeleteUserLinkedCustomer(Request $request): Users;
}
